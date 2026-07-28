<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <a href="{{ route('qc.queue') }}" class="text-xs text-gray-500 hover:text-gray-900">&larr; QC queue</a>
                <h1 class="text-lg font-semibold text-gray-900">Editor defect rates</h1>
            </div>

            @if ($periods->isNotEmpty())
                <form method="GET" class="flex items-center gap-2">
                    <label for="period" class="text-xs text-gray-500">Month</label>
                    <select name="period" id="period" onchange="this.form.submit()"
                            class="rounded-md border-gray-300 text-sm">
                        @foreach ($periods as $option)
                            <option value="{{ $option }}" @selected($option === $period)>{{ $option }}</option>
                        @endforeach
                    </select>
                </form>
            @endif
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto mb-6">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-3 py-2 text-left">Editor</th>
                    <th class="px-3 py-2 text-right">Reviews</th>
                    <th class="px-3 py-2 text-right">Rejected</th>
                    <th class="px-3 py-2 text-right">Reject rate</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($stats as $stat)
                    <tr class="{{ $stat->isHigh() ? 'bg-red-50' : '' }}">
                        <td class="px-3 py-2 text-gray-900">{{ $stat->editor?->name ?? 'Unknown' }}</td>
                        <td class="px-3 py-2 text-right text-gray-600">{{ $stat->total_reviews }}</td>
                        <td class="px-3 py-2 text-right text-gray-600">{{ $stat->rejected_count }}</td>
                        <td class="px-3 py-2 text-right">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $stat->badgeClasses() }}">
                                {{ number_format($stat->reject_rate, 1) }}%
                            </span>
                            @unless ($stat->isSignificant())
                                <div class="text-[10px] text-gray-400 mt-0.5">too few reviews</div>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-3 py-10 text-center text-gray-400">
                            No reviews were completed in {{ $period }}.
                        </td>
                    </tr>
                @endforelse

                @foreach ($untracked as $editor)
                    <tr class="text-gray-400">
                        <td class="px-3 py-2">{{ $editor->name }}</td>
                        <td class="px-3 py-2 text-right">0</td>
                        <td class="px-3 py-2 text-right">0</td>
                        <td class="px-3 py-2 text-right text-xs">no reviews</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h2 class="text-sm font-semibold text-gray-900 mb-2">Reading these figures</h2>
        <ul class="space-y-1.5 text-sm text-gray-600">
            <li class="flex gap-2">
                <span class="text-[#C3009D]">&bull;</span>
                <span>A rate at or above {{ App\Support\DefectRate::HIGH_THRESHOLD }}% is highlighted in red.</span>
            </li>
            <li class="flex gap-2">
                <span class="text-[#C3009D]">&bull;</span>
                <span>
                    Rates are greyed out below {{ App\Support\DefectRate::MIN_SAMPLE }} reviews: one rejection out of
                    two is 50% and means nothing.
                </span>
            </li>
            <li class="flex gap-2">
                <span class="text-[#C3009D]">&bull;</span>
                <span>The editor is recorded when the review opens, so reassigning a batch afterwards cannot move the mark.</span>
            </li>
        </ul>
    </div>
</x-app-layout>
