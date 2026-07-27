<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('leads.index') }}" class="text-xs text-gray-500 hover:text-gray-900">&larr; All leads</a>
            <h1 class="text-lg font-semibold text-gray-900">Add lead</h1>
        </div>
    </x-slot>

    @include('partials.flash')

    <form method="POST" action="{{ route('leads.store') }}" class="bg-white rounded-lg border border-gray-200 p-6 max-w-3xl">
        @csrf

        @include('leads.partials.form', ['lead' => null])

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="px-4 py-2 rounded-md bg-[#01015E] text-white text-sm hover:bg-[#01015E]/90">
                Create lead
            </button>
            <a href="{{ route('leads.index') }}" class="text-sm text-gray-500 hover:text-gray-900">Cancel</a>
        </div>
    </form>
</x-app-layout>
