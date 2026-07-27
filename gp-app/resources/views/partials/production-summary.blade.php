{{-- Production widget for the admin and production dashboards. Expects
     $production from DashboardController::productionSummary(). --}}
@php use App\Enums\OrderStatus; @endphp

<div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="text-2xl font-semibold text-gray-900">{{ $production['open'] }}</div>
        <div class="text-xs text-gray-500 mt-0.5">Open orders</div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="text-2xl font-semibold text-gray-900">{{ $production['dueToday'] }}</div>
        <div class="text-xs text-gray-500 mt-0.5">Due today</div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="text-2xl font-semibold {{ $production['unassigned'] > 0 ? 'text-[#C3009D]' : 'text-gray-900' }}">
            {{ $production['unassigned'] }}
        </div>
        <div class="text-xs text-gray-500 mt-0.5">Awaiting a team leader</div>
    </div>
    <div class="bg-white rounded-lg border {{ $production['atRiskCount'] > 0 ? 'border-red-300 bg-red-50' : 'border-gray-200' }} p-4">
        <div class="text-2xl font-semibold {{ $production['atRiskCount'] > 0 ? 'text-red-700' : 'text-gray-900' }}">
            {{ $production['atRiskCount'] }}
        </div>
        <div class="text-xs {{ $production['atRiskCount'] > 0 ? 'text-red-700' : 'text-gray-500' }} mt-0.5">
            At risk of breaching SLA
        </div>
    </div>
</div>

<div class="mb-6 grid gap-6 lg:grid-cols-3">
    {{-- Orders by stage --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-900">Production</h2>
            <a href="{{ route('orders.index') }}" class="text-xs text-[#C3009D] hover:underline">Open board</a>
        </div>

        <ul class="space-y-2">
            @foreach (OrderStatus::cases() as $status)
                <li class="flex items-center justify-between">
                    <span class="text-sm text-gray-700">{{ $status->label() }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $status->badgeClasses() }}">
                        {{ $production['counts'][$status->value] }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- At-risk list: 80% or more of the SLA window consumed --}}
    <div class="lg:col-span-2 bg-white rounded-lg border {{ $production['atRisk']->isNotEmpty() ? 'border-red-200' : 'border-gray-200' }} p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-900">Orders at risk</h2>
            <a href="{{ route('orders.index', ['at_risk' => 1]) }}" class="text-xs text-[#C3009D] hover:underline">
                See all
            </a>
        </div>

        @forelse ($production['atRisk'] as $order)
            @php($sla = $order->sla())
            <div class="flex items-center justify-between gap-3 py-2 border-b border-gray-100 last:border-0">
                <div class="min-w-0">
                    <a href="{{ route('orders.show', $order) }}" class="text-sm font-medium text-gray-900 hover:text-[#C3009D]">
                        {{ $order->reference }}
                    </a>
                    <div class="text-xs text-gray-500 truncate">
                        {{ $order->client?->displayName() }} &middot;
                        {{ number_format($order->image_count) }} images &middot;
                        {{ $order->teamLeader?->name ?? 'Unassigned' }}
                    </div>
                </div>
                <span class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium {{ $sla->badgeClasses() }}">
                    {{ $sla->label() }}
                </span>
            </div>
        @empty
            <p class="text-sm text-gray-500">Nothing is close to breaching its deadline.</p>
        @endforelse
    </div>
</div>
