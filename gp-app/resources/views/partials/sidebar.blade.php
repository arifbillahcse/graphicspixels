@php
    // Feature areas are gated on the same permissions seeded in PermissionMatrix,
    // so the sidebar visibly differs per role. Items without a route have not
    // been built yet and show the phase they arrive in.
    $navItems = [
        ['label' => 'Leads',           'permission' => 'leads.view',      'route' => 'leads.index'],
        ['label' => 'Clients',         'permission' => 'clients.view',    'phase' => 2],
        ['label' => 'Orders',          'permission' => 'orders.view',     'route' => 'orders.index'],
        ['label' => 'My batches',      'permission' => 'batches.view',    'route' => 'batches.mine'],
        ['label' => 'Quality Control', 'permission' => 'qc.view',         'route' => 'qc.queue'],
        ['label' => 'Staff',           'permission' => 'staff.view',      'route' => 'staff.index'],
        ['label' => 'Workload',        'permission' => 'staff.workload.view', 'route' => 'staff.workload'],
        // Leave has no permission: everyone books their own, and the policy
        // decides who may act on somebody else's.
        ['label' => 'Leave',           'permission' => null,              'route' => 'leave.index'],
        ['label' => 'Reports',         'permission' => 'reports.view',    'route' => 'reports.index'],
        ['label' => 'Settings',        'permission' => 'settings.manage', 'phase' => 6],
    ];
@endphp

{{-- Fixed and hidden below lg, where the navbar's toggle reveals it. --}}
<aside data-sidebar
       class="hidden lg:flex w-64 shrink-0 bg-[#01015E] text-white flex-col
              fixed lg:static inset-y-0 left-0 z-40 overflow-y-auto">
    <div class="px-5 py-4 border-b border-white/10">
        <div class="font-bold tracking-tight">Graphics<span class="text-[#C3009D]">Pixels</span></div>
        <div class="text-xs text-white/50 mt-0.5">Operations Platform</div>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded-md text-sm font-medium bg-white/10 text-white">
            Dashboard
        </a>

        @foreach ($navItems as $item)
            @if ($item['permission'] === null || auth()->user()->can($item['permission']))
                @if (isset($item['route']))
                    <a href="{{ route($item['route']) }}"
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs(Str::before($item['route'], '.').'.*') ? 'bg-white/10 text-white' : 'text-white/80 hover:bg-white/5 hover:text-white' }}">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="flex items-center justify-between px-3 py-2 rounded-md text-sm text-white/45 cursor-not-allowed"
                          title="Arrives in phase {{ $item['phase'] }}">
                        {{ $item['label'] }}
                        <span class="text-[10px] uppercase tracking-wide bg-white/10 px-1.5 py-0.5 rounded">
                            P{{ $item['phase'] }}
                        </span>
                    </span>
                @endif
            @endif
        @endforeach
    </nav>

    <div class="px-5 py-3 border-t border-white/10 text-[11px] text-white/40">
        Phase 5 &middot; Team &amp; reporting
    </div>
</aside>
