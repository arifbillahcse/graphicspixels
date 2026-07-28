<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">Quality Control Dashboard</h1>
            <a href="{{ route('qc.queue') }}" class="text-sm text-[#C3009D] hover:underline">Open the queue</a>
        </div>
    </x-slot>

    @include('partials.qc-summary')

    @include('partials.role-panel', [
        'summary' => 'Reviews every batch before it reaches the client, against the ISO-standard checks the studio advertises. Rejecting a batch sends it straight back to the editor who worked it.',
        'upcoming' => [
            'Email alerts to editors when their work is sent back',
            'Defect trends over several months, and by service type',
        ],
    ])
</x-app-layout>
