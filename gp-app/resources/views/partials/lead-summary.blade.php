{{-- Pipeline widget for the admin and marketing dashboards. Expects $leads
     from DashboardController::leadSummary(). --}}
@php use App\Enums\LeadStatus; @endphp

<div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="text-2xl font-semibold text-gray-900">{{ $leads['today'] }}</div>
        <div class="text-xs text-gray-500 mt-0.5">New leads today</div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="text-2xl font-semibold text-gray-900">{{ $leads['open'] }}</div>
        <div class="text-xs text-gray-500 mt-0.5">Open in pipeline</div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="text-2xl font-semibold {{ $leads['unassigned'] > 0 ? 'text-[#C3009D]' : 'text-gray-900' }}">
            {{ $leads['unassigned'] }}
        </div>
        <div class="text-xs text-gray-500 mt-0.5">Unassigned</div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="text-2xl font-semibold text-gray-900">{{ $leads['total'] }}</div>
        <div class="text-xs text-gray-500 mt-0.5">Total leads</div>
    </div>
</div>

<div class="mb-6 grid gap-6 lg:grid-cols-3">
    {{-- Counts by stage --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-900">Pipeline</h2>
            <a href="{{ route('leads.index') }}" class="text-xs text-[#C3009D] hover:underline">Open board</a>
        </div>

        <ul class="space-y-2">
            @foreach (LeadStatus::cases() as $status)
                <li class="flex items-center justify-between">
                    <a href="{{ route('leads.index', ['view' => 'table', 'status' => $status->value]) }}"
                       class="text-sm text-gray-700 hover:text-[#C3009D]">
                        {{ $status->label() }}
                    </a>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $status->badgeClasses() }}">
                        {{ $leads['counts'][$status->value] }}
                    </span>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Recent activity --}}
    <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6">
        <h2 class="text-sm font-semibold text-gray-900 mb-4">Recent activity</h2>

        <ol class="space-y-3">
            @forelse ($leads['recent'] as $activity)
                <li class="flex gap-3">
                    <div class="w-1.5 h-1.5 rounded-full bg-[#C3009D] mt-2 shrink-0"></div>
                    <div class="min-w-0">
                        <div class="text-sm text-gray-900">
                            @if ($activity->lead)
                                <a href="{{ route('leads.show', $activity->lead) }}" class="font-medium hover:text-[#C3009D]">
                                    {{ $activity->lead->name }}
                                </a>
                                &mdash;
                            @endif
                            {{ $activity->summary() }}
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">
                            {{ $activity->actorName() }} &middot; {{ $activity->created_at?->diffForHumans() }}
                        </div>
                    </div>
                </li>
            @empty
                <li class="text-sm text-gray-500">
                    No activity yet. Leads will appear here as soon as the website starts forwarding submissions.
                </li>
            @endforelse
        </ol>
    </div>
</div>
