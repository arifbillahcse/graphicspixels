<?php

namespace App\Http\Controllers;

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
        return view('dashboard.admin');
    }

    public function marketing(): View
    {
        return view('dashboard.marketing');
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
}
