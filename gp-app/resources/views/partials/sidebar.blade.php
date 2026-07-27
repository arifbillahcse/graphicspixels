@php
    // Feature areas are gated on the same permissions seeded in PermissionMatrix,
    // so the sidebar visibly differs per role. The destinations themselves land
    // in later phases, hence the phase badge instead of a link.
    $navItems = [
        ['label' => 'Leads',           'permission' => 'leads.view',      'phase' => 2],
        ['label' => 'Clients',         'permission' => 'clients.view',    'phase' => 2],
        ['label' => 'Orders',          'permission' => 'orders.view',     'phase' => 3],
        ['label' => 'Batches',         'permission' => 'batches.view',    'phase' => 3],
        ['label' => 'Quality Control', 'permission' => 'qc.view',         'phase' => 4],
        ['label' => 'Staff',           'permission' => 'staff.view',      'phase' => 5],
        ['label' => 'Reports',         'permission' => 'reports.view',    'phase' => 5],
        ['label' => 'Settings',        'permission' => 'settings.manage', 'phase' => 6],
    ];
@endphp

<aside class="w-64 shrink-0 bg-[#01015E] text-white flex flex-col">
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
            @can($item['permission'])
                <span class="flex items-center justify-between px-3 py-2 rounded-md text-sm text-white/45 cursor-not-allowed"
                      title="Arrives in phase {{ $item['phase'] }}">
                    {{ $item['label'] }}
                    <span class="text-[10px] uppercase tracking-wide bg-white/10 px-1.5 py-0.5 rounded">
                        P{{ $item['phase'] }}
                    </span>
                </span>
            @endcan
        @endforeach
    </nav>

    <div class="px-5 py-3 border-t border-white/10 text-[11px] text-white/40">
        Phase 1 &middot; Foundation
    </div>
</aside>
