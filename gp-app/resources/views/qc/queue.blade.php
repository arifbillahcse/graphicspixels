<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">QC queue</h1>
            <a href="{{ route('qc.defects') }}" class="text-sm text-[#C3009D] hover:underline">Editor defect rates</a>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto mb-6">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-3 py-2 text-left">Order</th>
                    <th class="px-3 py-2 text-left">Batch</th>
                    <th class="px-3 py-2 text-left">Service</th>
                    <th class="px-3 py-2 text-left">Editor</th>
                    <th class="px-3 py-2 text-left">Images</th>
                    <th class="px-3 py-2 text-left">Deadline</th>
                    <th class="px-3 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($batches as $batch)
                    @php($sla = $batch->order->sla())
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2">
                            <span class="font-medium text-gray-900">{{ $batch->order->reference }}</span>
                            <div class="text-xs text-gray-500">{{ $batch->order->client?->displayName() }}</div>
                        </td>
                        <td class="px-3 py-2 text-gray-700">{{ $batch->label() }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $batch->order->service_type->label() }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $batch->editor?->name ?? 'Unassigned' }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ number_format($batch->image_count) }}</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $sla->badgeClasses() }}">
                                {{ $sla->label() }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-right">
                            <a href="{{ route('qc.show', $batch) }}"
                               class="px-3 py-1.5 rounded-md bg-[#01015E] text-white text-xs hover:bg-[#01015E]/90">
                                Review
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-3 py-10 text-center text-gray-400">
                            Nothing is waiting for review.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h2 class="text-sm font-semibold text-gray-900 mb-4">Recently reviewed</h2>

        @forelse ($recent as $review)
            <div class="flex items-center justify-between gap-3 py-2 border-b border-gray-100 last:border-0">
                <div class="min-w-0">
                    <span class="text-sm text-gray-900">
                        {{ $review->batch?->order?->reference }} &middot; {{ $review->batch?->label() }}
                    </span>
                    <div class="text-xs text-gray-500">
                        {{ $review->editor?->name ?? 'Unassigned' }} &middot;
                        reviewed by {{ $review->reviewer?->name ?? 'System' }} &middot;
                        {{ $review->completed_at?->diffForHumans() }}
                    </div>
                </div>
                <span class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium {{ $review->outcome->badgeClasses() }}">
                    {{ $review->outcome->label() }}
                </span>
            </div>
        @empty
            <p class="text-sm text-gray-500">No reviews yet.</p>
        @endforelse
    </div>
</x-app-layout>
