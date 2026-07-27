<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">No role assigned</h1>
    </x-slot>

    <div class="bg-white rounded-lg border border-gray-200 p-6 max-w-2xl">
        <p class="text-sm text-gray-600">
            Your account does not yet have a role, so there is no dashboard to show you.
            An administrator needs to assign one before you can use the platform.
        </p>
        <p class="mt-3 text-sm text-gray-500">
            Signed in as <span class="font-medium text-gray-700">{{ auth()->user()->email }}</span>.
        </p>
    </div>
</x-app-layout>
