<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Production Dashboard</h1>
    </x-slot>

    @include('partials.role-panel', [
        'summary' => 'Runs the production floor: incoming orders, assignment to team leaders, and the 24-hour delivery promise.',
        'upcoming' => [
            'Order board: Received, Assigned, Editing, QC, Revision, Delivered',
            'Assigning orders to team leaders and rebalancing workload',
            'SLA countdown with at-risk alerts before a deadline slips',
            'Throughput and turnaround reporting across the studio',
        ],
    ])
</x-app-layout>
