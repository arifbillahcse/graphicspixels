<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">Staff directory</h1>
            @can('viewWorkload', App\Models\User::class)
                <a href="{{ route('staff.workload') }}" class="text-sm text-[#C3009D] hover:underline">Workload board</a>
            @endcan
        </div>
    </x-slot>

    @include('partials.flash')

    <form method="GET" class="bg-white rounded-lg border border-gray-200 p-4 mb-6 flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[200px]">
            <label for="q" class="block text-xs font-medium text-gray-500 mb-1">Search</label>
            <input type="text" name="q" id="q" value="{{ $filters['q'] }}"
                   placeholder="Name, email or job title" class="w-full rounded-md border-gray-300 text-sm">
        </div>
        <div>
            <label for="department" class="block text-xs font-medium text-gray-500 mb-1">Department</label>
            <select name="department" id="department" class="rounded-md border-gray-300 text-sm">
                <option value="">All</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->value }}" @selected($filters['department'] === $dept->value)>
                        {{ $dept->label() }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-3 py-2 rounded-md bg-gray-900 text-white text-sm">Filter</button>
        <a href="{{ route('staff.index') }}" class="px-3 py-2 text-sm text-gray-500 hover:text-gray-900">Reset</a>
        <span class="ml-auto text-sm text-gray-500">{{ $staff->count() }} people</span>
    </form>

    <div class="bg-white rounded-lg border border-gray-200 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-3 py-2 text-left">Name</th>
                    <th class="px-3 py-2 text-left">Role</th>
                    <th class="px-3 py-2 text-left">Department</th>
                    <th class="px-3 py-2 text-left">Reports to</th>
                    <th class="px-3 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($staff as $person)
                    <tr class="hover:bg-gray-50 {{ $person->is_active ? '' : 'opacity-50' }}">
                        <td class="px-3 py-2">
                            <a href="{{ route('staff.show', $person) }}" class="font-medium text-gray-900 hover:text-[#C3009D]">
                                {{ $person->name }}
                            </a>
                            <div class="text-xs text-gray-500">{{ $person->job_title ?? $person->email }}</div>
                        </td>
                        <td class="px-3 py-2 text-gray-600">{{ $person->primaryRole()?->label() ?? '—' }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $person->department?->label() ?? '—' }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $person->teamLeader?->name ?? '—' }}</td>
                        <td class="px-3 py-2">
                            @if (! $person->is_active)
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-200 text-gray-700">Inactive</span>
                            @elseif (in_array($person->id, $onLeaveToday, true))
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">On leave</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Available</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-3 py-10 text-center text-gray-400">Nobody matches those filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
