<?php

namespace App\Http\Controllers;

use App\Enums\BatchStatus;
use App\Enums\LeadStatus;
use App\Enums\OrderStatus;
use App\Models\Batch;
use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\Order;
use App\Models\DefectStat;
use App\Models\QcReview;
use App\Support\DefectRate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Landing route after login. Breeze redirects to route('dashboard'), and
     * this forwards each user to the dashboard belonging to their role.
     *
     * A user with no recognised role is shown an explanatory page rather than
     * being redirected, which would loop back through this method.
     */
    public function index(Request $request): RedirectResponse|View
    {
        $role = $request->user()->primaryRole();

        if ($role === null) {
            return view('dashboard.unassigned');
        }

        return redirect()->route($role->dashboardRoute());
    }

    public function admin(): View
    {
        return view('dashboard.admin', [
            'leads' => $this->leadSummary(),
            'production' => $this->productionSummary(),
            'qc' => $this->qcSummary(),
        ]);
    }

    public function marketing(): View
    {
        return view('dashboard.marketing', ['leads' => $this->leadSummary()]);
    }

    public function production(): View
    {
        return view('dashboard.production', ['production' => $this->productionSummary()]);
    }

    public function team(Request $request): View
    {
        $userId = $request->user()->id;

        return view('dashboard.team', [
            'queue' => Order::forTeamLeader($userId)
                ->open()
                ->with('client')
                ->withCount('batches')
                ->orderBy('deadline')
                ->get(),
            'unbatched' => Order::forTeamLeader($userId)
                ->open()
                ->doesntHave('batches')
                ->count(),
        ]);
    }

    public function editor(Request $request): View
    {
        $batches = Batch::forEditor($request->user()->id)
            ->with('order.client')
            ->orderBy('status')
            ->get();

        return view('dashboard.editor', [
            'batches' => $batches,
            'openBatches' => $batches->filter(fn (Batch $b) => $b->status->isOpen())->count(),
            'revisions' => $batches->where('status', BatchStatus::Revision)->count(),
        ]);
    }

    public function qc(): View
    {
        return view('dashboard.qc', ['qc' => $this->qcSummary()]);
    }

    /**
     * Pipeline figures for the admin and marketing dashboards.
     *
     * @return array{counts:array<string,int>,today:int,open:int,unassigned:int,total:int,recent:\Illuminate\Support\Collection}
     */
    private function leadSummary(): array
    {
        $counts = Lead::query()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->all();

        $byStatus = [];

        foreach (LeadStatus::cases() as $status) {
            $byStatus[$status->value] = (int) ($counts[$status->value] ?? 0);
        }

        $closed = $byStatus[LeadStatus::Converted->value] + $byStatus[LeadStatus::Lost->value];

        return [
            'counts' => $byStatus,
            'today' => Lead::whereDate('created_at', today())->count(),
            'open' => array_sum($byStatus) - $closed,
            'unassigned' => Lead::whereNull('assigned_to')
                ->whereNotIn('status', [LeadStatus::Converted->value, LeadStatus::Lost->value])
                ->count(),
            'total' => array_sum($byStatus),
            'recent' => LeadActivity::with(['lead', 'user'])->latest()->limit(10)->get(),
        ];
    }

    /**
     * Production figures for the admin and production dashboards.
     *
     * @return array<string,mixed>
     */
    private function productionSummary(): array
    {
        $counts = Order::query()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status')
            ->all();

        $byStatus = [];

        foreach (OrderStatus::cases() as $status) {
            $byStatus[$status->value] = (int) ($counts[$status->value] ?? 0);
        }

        return [
            'counts' => $byStatus,
            'open' => array_sum($byStatus) - $byStatus[OrderStatus::Delivered->value],
            'unassigned' => Order::open()->whereNull('team_leader_id')->count(),
            'dueToday' => Order::open()->whereDate('deadline', today())->count(),
            'atRiskCount' => Order::atRisk()->count(),
            'atRisk' => Order::atRisk()
                ->with(['client', 'teamLeader'])
                ->orderBy('deadline')
                ->limit(10)
                ->get(),
        ];
    }

    /**
     * Quality-control figures for the admin and QC dashboards.
     *
     * @return array<string,mixed>
     */
    private function qcSummary(): array
    {
        $period = DefectRate::period();

        $stats = DefectStat::period($period)
            ->with('editor')
            ->get()
            ->sortByDesc('reject_rate')
            ->values();

        return [
            'period' => $period,
            'waiting' => Batch::where('status', BatchStatus::ReadyForQc->value)->count(),
            'inRevision' => Batch::where('status', BatchStatus::Revision->value)->count(),
            'reviewedThisMonth' => (int) $stats->sum('total_reviews'),
            'rejectedThisMonth' => (int) $stats->sum('rejected_count'),
            'studioRate' => DefectRate::calculate(
                (int) $stats->sum('total_reviews'),
                (int) $stats->sum('rejected_count'),
            ),
            'stats' => $stats,
            'recent' => QcReview::completed()
                ->with(['batch.order', 'editor', 'reviewer'])
                ->latest('completed_at')
                ->limit(5)
                ->get(),
        ];
    }
}
