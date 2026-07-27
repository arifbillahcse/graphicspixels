{{-- Table view with bulk actions. The whole table is one form, so rows contain
     no nested forms; per-lead actions live on the detail page. --}}
<form method="POST" action="{{ route('leads.bulk') }}">
    @csrf

    @can('updateAny', App\Models\Lead::class)
        <div class="bg-white rounded-t-lg border border-b-0 border-gray-200 p-3 flex flex-wrap items-end gap-3">
            <div>
                <label for="bulk-action" class="block text-xs font-medium text-gray-500 mb-1">Bulk action</label>
                <select name="action" id="bulk-action" class="rounded-md border-gray-300 text-sm">
                    <option value="status">Set status</option>
                    @can('assignAny', App\Models\Lead::class)
                        <option value="assign">Assign owner</option>
                    @endcan
                </select>
            </div>

            <div>
                <label for="bulk-status" class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                <select name="status" id="bulk-status" class="rounded-md border-gray-300 text-sm">
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>

            @can('assignAny', App\Models\Lead::class)
                <div>
                    <label for="bulk-assignee" class="block text-xs font-medium text-gray-500 mb-1">Owner</label>
                    <select name="assigned_to" id="bulk-assignee" class="rounded-md border-gray-300 text-sm">
                        <option value="">Unassigned</option>
                        @foreach ($assignees as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endcan

            <button type="submit" class="px-3 py-2 rounded-md bg-gray-900 text-white text-sm">
                Apply to selected
            </button>
        </div>
    @endcan

    <div class="bg-white border border-gray-200 rounded-b-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-3 py-2 w-8"></th>
                    <th class="px-3 py-2 text-left">Name</th>
                    <th class="px-3 py-2 text-left">Service</th>
                    <th class="px-3 py-2 text-left">Source</th>
                    <th class="px-3 py-2 text-left">Status</th>
                    <th class="px-3 py-2 text-left">Owner</th>
                    <th class="px-3 py-2 text-left">Received</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($leads as $lead)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2">
                            <input type="checkbox" name="lead_ids[]" value="{{ $lead->id }}"
                                   class="rounded border-gray-300">
                        </td>
                        <td class="px-3 py-2">
                            <a href="{{ route('leads.show', $lead) }}" class="font-medium text-gray-900 hover:text-[#C3009D]">
                                {{ $lead->name }}
                            </a>
                            <div class="text-xs text-gray-500">{{ $lead->email }}</div>
                        </td>
                        <td class="px-3 py-2 text-gray-600">{{ $lead->service ?? '—' }}</td>
                        <td class="px-3 py-2 text-gray-600">{{ $lead->source->label() }}</td>
                        <td class="px-3 py-2">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $lead->status->badgeClasses() }}">
                                {{ $lead->status->label() }}
                            </span>
                        </td>
                        <td class="px-3 py-2 text-gray-600">{{ $lead->assignee?->name ?? 'Unassigned' }}</td>
                        <td class="px-3 py-2 text-gray-500 whitespace-nowrap">
                            {{ $lead->created_at?->format('d M Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-3 py-10 text-center text-gray-400">No leads match these filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</form>

<div class="mt-4">
    {{ $leads->links() }}
</div>
