<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">Editor Dashboard</h1>
            <a href="{{ route('batches.mine') }}" class="text-sm text-[#C3009D] hover:underline">Open my batches</a>
        </div>
    </x-slot>

    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">{{ $openBatches }}</div>
            <div class="text-xs text-gray-500 mt-0.5">Open batches</div>
        </div>
        <div class="bg-white rounded-lg border {{ $revisions > 0 ? 'border-orange-300 bg-orange-50' : 'border-gray-200' }} p-4">
            <div class="text-2xl font-semibold {{ $revisions > 0 ? 'text-orange-700' : 'text-gray-900' }}">
                {{ $revisions }}
            </div>
            <div class="text-xs {{ $revisions > 0 ? 'text-orange-700' : 'text-gray-500' }} mt-0.5">
                Sent back for revision
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">
                {{ number_format($batches->where('status', App\Enums\BatchStatus::Pending)->sum('image_count') + $batches->where('status', App\Enums\BatchStatus::InProgress)->sum('image_count')) }}
            </div>
            <div class="text-xs text-gray-500 mt-0.5">Images still to edit</div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-gray-900">My work</h2>
            <a href="{{ route('batches.mine') }}" class="text-xs text-[#C3009D] hover:underline">Full list</a>
        </div>

        @forelse ($batches->take(8) as $batch)
            @php($sla = $batch->order->sla())
            <div class="flex flex-wrap items-center justify-between gap-3 py-3 border-b border-gray-100 last:border-0">
                <div class="min-w-0">
                    <span class="text-sm font-medium text-gray-900">{{ $batch->order->reference }}</span>
                    <span class="text-xs text-gray-500 ml-1">{{ $batch->label() }}</span>
                    <div class="text-xs text-gray-500">
                        {{ number_format($batch->image_count) }} images &middot;
                        {{ $batch->order->service_type->label() }}
                    </div>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $batch->status->badgeClasses() }}">
                        {{ $batch->status->label() }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $sla->badgeClasses() }}">
                        {{ $sla->label() }}
                    </span>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">No batches are assigned to you right now.</p>
        @endforelse
    </div>

    @include('partials.role-panel', [
        'summary' => 'Shows only the batches assigned to you. Editors deliberately cannot see leads, orders, or other editors\' work.',
        'upcoming' => [
            'Quality control feedback with blocker and minor comments',
            'Your own defect rate over time',
        ],
    ])
</x-app-layout>
