<?php

namespace App\Http\Controllers;

use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\LeadActivity;
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
        return view('dashboard.admin', ['leads' => $this->leadSummary()]);
    }

    public function marketing(): View
    {
        return view('dashboard.marketing', ['leads' => $this->leadSummary()]);
    }

    public function production(): View
    {
        return view('dashboard.production');
    }

    public function team(): View
    {
        return view('dashboard.team');
    }

    public function editor(): View
    {
        return view('dashboard.editor');
    }

    public function qc(): View
    {
        return view('dashboard.qc');
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
}
