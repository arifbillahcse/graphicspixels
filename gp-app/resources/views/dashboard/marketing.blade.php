<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Marketing Dashboard</h1>
    </x-slot>

    @include('partials.lead-summary')

    @include('partials.role-panel', [
        'summary' => 'Owns the lead pipeline from website enquiry through to a converted client. The pipeline is live: free-trial and contact submissions forwarded by the website land in Leads automatically.',
        'upcoming' => [
            'Client profiles with brand guidelines and pricing tier',
            'Converting a won lead into a production order',
            'Email notifications when a lead is assigned to you',
        ],
    ])
</x-app-layout>
