<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Production Dashboard</h1>
    </x-slot>

    @include('partials.production-summary')

    @include('partials.role-panel', [
        'summary' => 'Runs the production floor: incoming orders, assignment to team leaders, and the 24-hour delivery promise. The board is live — orders arrive here as soon as marketing converts a lead.',
        'upcoming' => [
            'Quality control sign-off before delivery',
            'Per-editor defect rates and throughput reporting',
            'Automatic alerts when an order is about to breach its SLA',
        ],
    ])
</x-app-layout>
