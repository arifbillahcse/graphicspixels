<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">Leads</h1>
            @can('create', App\Models\Lead::class)
                <a href="{{ route('leads.create') }}"
                   class="px-3 py-2 rounded-md bg-[#01015E] text-white text-sm font-medium hover:bg-[#01015E]/90">
                    Add lead
                </a>
            @endcan
        </div>
    </x-slot>

    @include('partials.flash')

    {{-- Status summary --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
        @foreach ($statuses as $status)
            <a href="{{ route('leads.index', ['view' => 'table', 'status' => $status->value]) }}"
               class="bg-white rounded-lg border border-gray-200 p-3 hover:border-[#C3009D] transition">
                <div class="text-2xl font-semibold text-gray-900">{{ $counts[$status->value] }}</div>
                <div class="text-xs text-gray-500 mt-0.5">{{ $status->label() }}</div>
            </a>
        @endforeach
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('leads.index') }}"
          class="bg-white rounded-lg border border-gray-200 p-4 mb-6 flex flex-wrap items-end gap-3">
        <input type="hidden" name="view" value="{{ $view }}">

        <div class="flex-1 min-w-[200px]">
            <label for="q" class="block text-xs font-medium text-gray-500 mb-1">Search</label>
            <input type="text" name="q" id="q" value="{{ $filters['q'] }}"
                   placeholder="Name, email, company or website"
                   class="w-full rounded-md border-gray-300 text-sm">
        </div>

        <div>
            <label for="source" class="block text-xs font-medium text-gray-500 mb-1">Source</label>
            <select name="source" id="source" class="rounded-md border-gray-300 text-sm">
                <option value="">All</option>
                @foreach ($sources as $source)
                    <option value="{{ $source->value }}" @selected($filters['source'] === $source->value)>
                        {{ $source->label() }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="assigned" class="block text-xs font-medium text-gray-500 mb-1">Owner</label>
            <select name="assigned" id="assigned" class="rounded-md border-gray-300 text-sm">
                <option value="">Anyone</option>
                <option value="unassigned" @selected($filters['assigned'] === 'unassigned')>Unassigned</option>
                @foreach ($assignees as $user)
                    <option value="{{ $user->id }}" @selected($filters['assigned'] === (string) $user->id)>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="px-3 py-2 rounded-md bg-gray-900 text-white text-sm">Filter</button>
        <a href="{{ route('leads.index', ['view' => $view]) }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-900">Reset</a>

        <div class="ml-auto flex rounded-md border border-gray-300 overflow-hidden text-sm">
            <a href="{{ route('leads.index', array_merge($filters, ['view' => 'board'])) }}"
               class="px-3 py-2 {{ $view === 'board' ? 'bg-gray-900 text-white' : 'text-gray-600' }}">Board</a>
            <a href="{{ route('leads.index', array_merge($filters, ['view' => 'table'])) }}"
               class="px-3 py-2 {{ $view === 'table' ? 'bg-gray-900 text-white' : 'text-gray-600' }}">Table</a>
        </div>
    </form>

    @if ($view === 'board')
        @include('leads.partials.board')
    @else
        @include('leads.partials.table')
    @endif
</x-app-layout>
