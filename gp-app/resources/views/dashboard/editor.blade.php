<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Editor Dashboard</h1>
    </x-slot>

    @include('partials.role-panel', [
        'summary' => 'Shows only the batches assigned to you. Editors deliberately cannot see leads, orders, or other editors\' work.',
        'upcoming' => [
            'My batches, with image count and deadline',
            'Marking a batch In Progress or Ready for QC',
            'Rework queue when QC sends a batch back with comments',
        ],
    ])
</x-app-layout>
