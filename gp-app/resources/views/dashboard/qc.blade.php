<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Quality Control Dashboard</h1>
    </x-slot>

    @include('partials.role-panel', [
        'summary' => 'Reviews every batch before it reaches the client, against the ISO-standard checks the studio advertises.',
        'upcoming' => [
            'QC queue of batches marked Ready for QC',
            'Service-specific checklists (clipping path, retouching, ghost mannequin)',
            'Approve, or reject with blocker and minor comments',
            'Per-editor defect rates over time',
        ],
    ])
</x-app-layout>
