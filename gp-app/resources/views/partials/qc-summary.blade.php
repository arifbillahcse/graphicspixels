{{-- Quality-control widget for the admin and QC dashboards. Expects $qc from
     DashboardController::qcSummary(). --}}

<div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <div class="bg-white rounded-lg border {{ $qc['waiting'] > 0 ? 'border-purple-300 bg-purple-50' : 'border-gray-200' }} p-4">
        <div class="text-2xl font-semibold {{ $qc['waiting'] > 0 ? 'text-purple-800' : 'text-gray-900' }}">
            {{ $qc['waiting'] }}
        </div>
        <div class="text-xs {{ $qc['waiting'] > 0 ? 'text-purple-800' : 'text-gray-500' }} mt-0.5">
            Waiting for review
        </div>
    </div>
    <div class="bg-white rounded-lg border {{ $qc['inRevision'] > 0 ? 'border-orange-300 bg-orange-50' : 'border-gray-200' }} p-4">
        <div class="text-2xl font-semibold {{ $qc['inRevision'] > 0 ? 'text-orange-700' : 'text-gray-900' }}">
            {{ $qc['inRevision'] }}
        </div>
        <div class="text-xs {{ $qc['inRevision'] > 0 ? 'text-orange-700' : 'text-gray-500' }} mt-0.5">
            Back with editors
        </div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="text-2xl font-semibold text-gray-900">{{ $qc['reviewedThisMonth'] }}</div>
        <div class="text-xs text-gray-500 mt-0.5">Reviewed this month</div>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <div class="text-2xl font-semibold {{ $qc['studioRate'] >= App\Support\DefectRate::HIGH_THRESHOLD ? 'text-red-700' : 'text-gray-900' }}">
            {{ number_format($qc['studioRate'], 1) }}%
        </div>
        <div class="text-xs text-gray-500 mt-0.5">Studio reject rate</div>
    </div>
</div>

<div class="mb-6 grid gap-6 lg:grid-cols-2">
    {{-- Editor defect rates, worst first --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-900">Editor defect rates</h2>
            <a href="{{ route('qc.defects') }}" class="text-xs text-[#C3009D] hover:underline">Full table</a>
        </div>

        @forelse ($qc['stats']->take(6) as $stat)
            <div class="flex items-center justify-between gap-3 py-2 border-b border-gray-100 last:border-0">
                <div class="min-w-0">
                    <span class="text-sm text-gray-900">{{ $stat->editor?->name ?? 'Unknown' }}</span>
                    <div class="text-xs text-gray-500">
                        {{ $stat->rejected_count }} rejected of {{ $stat->total_reviews }}
                    </div>
                </div>
                <span class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium {{ $stat->badgeClasses() }}">
                    {{ number_format($stat->reject_rate, 1) }}%
                </span>
            </div>
        @empty
            <p class="text-sm text-gray-500">No reviews completed in {{ $qc['period'] }} yet.</p>
        @endforelse
    </div>

    {{-- Recent decisions --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-900">Recent decisions</h2>
            <a href="{{ route('qc.queue') }}" class="text-xs text-[#C3009D] hover:underline">Open queue</a>
        </div>

        @forelse ($qc['recent'] as $review)
            <div class="flex items-center justify-between gap-3 py-2 border-b border-gray-100 last:border-0">
                <div class="min-w-0">
                    <span class="text-sm text-gray-900">
                        {{ $review->batch?->order?->reference }} &middot; {{ $review->batch?->label() }}
                    </span>
                    <div class="text-xs text-gray-500">
                        {{ $review->editor?->name ?? 'Unassigned' }} &middot;
                        {{ $review->completed_at?->diffForHumans() }}
                    </div>
                </div>
                <span class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium {{ $review->outcome->badgeClasses() }}">
                    {{ $review->outcome->label() }}
                </span>
            </div>
        @empty
            <p class="text-sm text-gray-500">Nothing reviewed yet.</p>
        @endforelse
    </div>
</div>
