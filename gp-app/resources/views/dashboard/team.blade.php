<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Team Leader Dashboard</h1>
    </x-slot>

    @include('partials.role-panel', [
        'summary' => 'Splits assigned orders into batches and distributes them across the editors in your team.',
        'upcoming' => [
            'Queue of orders assigned to your team',
            'Splitting an order into batches and assigning each to an editor',
            'Live workload per editor, with rebalancing',
            'Your team\'s delivery and QC reject rates',
        ],
    ])
</x-app-layout>
