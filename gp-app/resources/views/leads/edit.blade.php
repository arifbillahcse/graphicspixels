<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('leads.show', $lead) }}" class="text-xs text-gray-500 hover:text-gray-900">&larr; Back to lead</a>
            <h1 class="text-lg font-semibold text-gray-900">Edit {{ $lead->name }}</h1>
        </div>
    </x-slot>

    @include('partials.flash')

    <form method="POST" action="{{ route('leads.update', $lead) }}" class="bg-white rounded-lg border border-gray-200 p-6 max-w-3xl">
        @csrf
        @method('PUT')

        @include('leads.partials.form', ['lead' => $lead])

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="px-4 py-2 rounded-md bg-[#01015E] text-white text-sm hover:bg-[#01015E]/90">
                Save changes
            </button>
            <a href="{{ route('leads.show', $lead) }}" class="text-sm text-gray-500 hover:text-gray-900">Cancel</a>
        </div>
    </form>
</x-app-layout>
