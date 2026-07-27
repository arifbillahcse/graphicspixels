<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Marketing Dashboard</h1>
    </x-slot>

    @include('partials.role-panel', [
        'summary' => 'Owns the lead pipeline from website enquiry through to a converted client.',
        'upcoming' => [
            'Free-trial and contact submissions arriving from the WordPress site',
            'Lead pipeline: New, Contacted, Trial Sent, Negotiating, Converted, Lost',
            'Client profiles with brand guidelines and pricing tier',
            'Converting a won lead into a production order',
        ],
    ])
</x-app-layout>
