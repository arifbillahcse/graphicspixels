@php
    /** Direction arrow comparing this period against the last. */
    $delta = function (float|int $now, float|int $then): string {
        if ($then == 0) {
            return $now > 0 ? '↑' : '–';
        }
        $change = round(($now - $then) / $then * 100);

        return $change > 0 ? "↑ {$change}%" : ($change < 0 ? '↓ '.abs($change).'%' : '–');
    };
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-lg font-semibold text-gray-900">Reports</h1>
                <p class="text-xs text-gray-500">{{ $range->label() }}</p>
            </div>

            <form method="GET" class="flex items-end gap-2">
                <div>
                    <label for="scope" class="block text-xs font-medium text-gray-500 mb-1">Period</label>
                    <select name="scope" id="scope" class="rounded-md border-gray-300 text-sm">
                        <option value="month" @selected($scope === 'month')>Month</option>
                        <option value="week" @selected($scope === 'week')>Week</option>
                    </select>
                </div>
                <div>
                    <label for="date" class="block text-xs font-medium text-gray-500 mb-1">Containing</label>
                    <input type="date" name="date" id="date" value="{{ request('date', $range->start) }}"
                           class="rounded-md border-gray-300 text-sm">
                </div>
                <button type="submit" class="px-3 py-2 rounded-md bg-gray-900 text-white text-sm">Show</button>
            </form>
        </div>
    </x-slot>

    @include('partials.flash')

    {{-- Headline figures --}}
    <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">{{ number_format($summary['orders']) }}</div>
            <div class="text-xs text-gray-500 mt-0.5">
                Orders received <span class="text-gray-400">{{ $delta($summary['orders'], $previous['orders']) }}</span>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">{{ number_format($summary['images']) }}</div>
            <div class="text-xs text-gray-500 mt-0.5">
                Images <span class="text-gray-400">{{ $delta($summary['images'], $previous['images']) }}</span>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">{{ number_format($summary['delivered']) }}</div>
            <div class="text-xs text-gray-500 mt-0.5">Delivered</div>
        </div>
        <div class="bg-white rounded-lg border {{ $summary['on_time_rate'] < 90 && $summary['delivered'] > 0 ? 'border-red-300' : 'border-gray-200' }} p-4">
            <div class="text-2xl font-semibold {{ $summary['on_time_rate'] < 90 && $summary['delivered'] > 0 ? 'text-red-700' : 'text-gray-900' }}">
                {{ number_format($summary['on_time_rate'], 1) }}%
            </div>
            <div class="text-xs text-gray-500 mt-0.5">On time</div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">{{ number_format($summary['avg_turnaround_hours'], 1) }}h</div>
            <div class="text-xs text-gray-500 mt-0.5">Average turnaround</div>
        </div>
    </div>

    {{-- By service --}}
    <div class="bg-white rounded-lg border border-gray-200 mb-6">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">By service</h2>
            @can('exportReports', App\Models\Order::class)
                <a href="{{ route('reports.export', ['report' => 'services', 'scope' => $scope, 'date' => $range->start]) }}"
                   class="text-xs text-[#C3009D] hover:underline">Export CSV</a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-3 py-2 text-left">Service</th>
                        <th class="px-3 py-2 text-right">Orders</th>
                        <th class="px-3 py-2 text-right">Images</th>
                        <th class="px-3 py-2 text-right">Delivered</th>
                        <th class="px-3 py-2 text-right">On time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($byService as $row)
                        <tr>
                            <td class="px-3 py-2 text-gray-900">{{ $row['service'] }}</td>
                            <td class="px-3 py-2 text-right text-gray-600">{{ number_format($row['orders']) }}</td>
                            <td class="px-3 py-2 text-right text-gray-600">{{ number_format($row['images']) }}</td>
                            <td class="px-3 py-2 text-right text-gray-600">{{ number_format($row['delivered']) }}</td>
                            <td class="px-3 py-2 text-right text-gray-600">{{ number_format($row['on_time_rate'], 1) }}%</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-3 py-8 text-center text-gray-400">No orders in this period.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Editor performance --}}
    <div class="bg-white rounded-lg border border-gray-200">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <h2 class="text-sm font-semibold text-gray-900">Editor performance</h2>
            @can('exportReports', App\Models\Order::class)
                <a href="{{ route('reports.export', ['report' => 'editors', 'scope' => $scope, 'date' => $range->start]) }}"
                   class="text-xs text-[#C3009D] hover:underline">Export CSV</a>
            @endcan
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-3 py-2 text-left">Editor</th>
                        <th class="px-3 py-2 text-right">Batches</th>
                        <th class="px-3 py-2 text-right">Images</th>
                        <th class="px-3 py-2 text-right">QC reviews</th>
                        <th class="px-3 py-2 text-right">Reject rate</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($editors as $row)
                        <tr>
                            <td class="px-3 py-2 text-gray-900">{{ $row['name'] }}</td>
                            <td class="px-3 py-2 text-right text-gray-600">{{ number_format($row['batches']) }}</td>
                            <td class="px-3 py-2 text-right text-gray-600">{{ number_format($row['images']) }}</td>
                            <td class="px-3 py-2 text-right text-gray-600">{{ number_format($row['reviews']) }}</td>
                            <td class="px-3 py-2 text-right">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ App\Support\DefectRate::badgeClasses($row['reject_rate'], $row['reviews']) }}">
                                    {{ number_format($row['reject_rate'], 1) }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-3 py-8 text-center text-gray-400">No completed work in this period.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @can('exportReports', App\Models\Order::class)
        <div class="mt-4">
            <a href="{{ route('reports.export', ['report' => 'orders', 'scope' => $scope, 'date' => $range->start]) }}"
               class="px-4 py-2 rounded-md bg-[#01015E] text-white text-sm hover:bg-[#01015E]/90 inline-block">
                Export full order list
            </a>
        </div>
    @endcan
</x-app-layout>
