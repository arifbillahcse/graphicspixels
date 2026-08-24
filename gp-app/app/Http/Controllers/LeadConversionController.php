<?php

namespace App\Http\Controllers;

use App\Enums\ActivityAction;
use App\Enums\LeadStatus;
use App\Enums\OrderStatus;
use App\Enums\RateTier;
use App\Enums\RoleName;
use App\Enums\ServiceType;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderCreated;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

/**
 * Turns a won lead into a client and their first production order.
 */
class LeadConversionController extends Controller
{
    public function create(Lead $lead): View
    {
        Gate::authorize('view', $lead);
        Gate::authorize('create', Order::class);

        return view('orders.convert', [
            'lead' => $lead,
            'existingClient' => Client::where('email', $lead->email)->first(),
            'serviceTypes' => ServiceType::cases(),
            'rateTiers' => RateTier::cases(),
            // Pre-select the service the client picked on the website.
            'guessedService' => ServiceType::guessFrom($lead->service),
            'defaultDeadline' => Order::defaultDeadline(),
            'teamLeaders' => User::role(RoleName::TeamLeader->value)
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request, Lead $lead): RedirectResponse
    {
        Gate::authorize('view', $lead);
        Gate::authorize('create', Order::class);

        $validated = $request->validate([
            'service_type' => ['required', 'string', 'in:'.implode(',', ServiceType::values())],
            'image_count' => ['required', 'integer', 'min:1', 'max:1000000'],
            'deadline' => ['required', 'date'],
            'rush' => ['nullable', 'boolean'],
            'file_intake_link' => ['nullable', 'string', 'max:2000'],
            'rate_tier' => ['required', 'string', 'in:'.implode(',', RateTier::values())],
            'team_leader_id' => ['nullable', 'integer', 'exists:users,id'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $actor = $request->user();

        $order = DB::transaction(function () use ($lead, $validated, $actor) {
            $client = Client::fromLead($lead);

            // A returning client may already sit on a negotiated tier; only
            // apply the submitted tier when it actually changes something.
            if ($client->rate_tier->value !== $validated['rate_tier']) {
                $client->update(['rate_tier' => $validated['rate_tier']]);
            }

            $deadline = Carbon::parse($validated['deadline']);
            $teamLeader = isset($validated['team_leader_id'])
                ? User::find($validated['team_leader_id'])
                : null;

            $order = Order::create([
                'reference' => Order::nextReference(),
                'client_id' => $client->id,
                'lead_id' => $lead->id,
                'service_type' => $validated['service_type'],
                'image_count' => $validated['image_count'],
                'file_intake_link' => $validated['file_intake_link'] ?? null,
                'status' => $teamLeader ? OrderStatus::Assigned->value : OrderStatus::Received->value,
                'rush' => (bool) ($validated['rush'] ?? false),
                'received_at' => now(),
                'deadline' => $deadline,
                'team_leader_id' => $teamLeader?->id,
                'created_by' => $actor?->id,
                'notes' => $validated['notes'] ?? null,
            ]);

            $order->addNote(
                sprintf('Order created from lead #%d (%s).', $lead->id, $lead->name),
                $actor,
            );

            if ($teamLeader) {
                $order->addNote("Assigned to {$teamLeader->name}.", $actor);
            }

            // Converting the lead is the point of this flow, so it happens
            // even if the lead was already sitting in another stage.
            $lead->changeStatus(LeadStatus::Converted, $actor);

            $lead->recordActivity(
                ActivityAction::StatusChanged,
                $actor,
                "Converted to client and order {$order->reference}.",
                ['order_id' => $order->id, 'client_id' => $client->id],
            );

            return $order;
        });

        // Production needs to know a job has landed. Sent outside the
        // transaction so nobody is told about an order that rolled back.
        User::role(RoleName::ProductionManager->value)
            ->where('is_active', true)
            ->when($actor, fn ($q) => $q->where('id', '!=', $actor->id))
            ->get()
            ->each(fn (User $manager) => $manager->notify(new OrderCreated($order)));

        return redirect()
            ->route('orders.show', $order)
            ->with('status', "Created order {$order->reference}.");
    }
}
