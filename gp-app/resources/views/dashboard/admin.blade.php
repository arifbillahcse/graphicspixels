<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Admin Dashboard</h1>
    </x-slot>

    @include('partials.role-panel', [
        'summary' => 'Full oversight across every department. Administrators automatically receive every permission in the system, including ones added in later phases.',
        'upcoming' => [
            'Company-wide totals: orders, images processed, on-time delivery rate',
            'Revenue by service type and top clients',
            'Team utilisation across all four departments',
            'User and role administration, plus system settings',
        ],
    ])
</x-app-layout>
