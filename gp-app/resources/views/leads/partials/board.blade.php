{{-- Pipeline board: one column per stage, with a per-card stage selector. --}}
<div class="overflow-x-auto pb-4">
    <div class="flex gap-4 min-w-max">
        @foreach ($statuses as $status)
            @php($columnLeads = $board->get($status->value, collect()))

            <div class="w-72 shrink-0">
                <div class="flex items-center justify-between mb-2 px-1">
                    <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        {{ $status->label() }}
                    </span>
                    <span class="text-xs text-gray-400">{{ $columnLeads->count() }}</span>
                </div>

                <div class="space-y-2">
                    @forelse ($columnLeads as $lead)
                        <div class="bg-white rounded-lg border border-gray-200 p-3">
                            <a href="{{ route('leads.show', $lead) }}"
                               class="block font-medium text-sm text-gray-900 hover:text-[#C3009D]">
                                {{ $lead->name }}
                            </a>
                            <div class="text-xs text-gray-500 truncate">{{ $lead->email }}</div>

                            @if ($lead->service)
                                <div class="mt-1 text-xs text-gray-600">{{ $lead->service }}</div>
                            @endif

                            <div class="mt-2 flex items-center justify-between gap-2">
                                <span class="text-[10px] uppercase tracking-wide text-gray-400">
                                    {{ $lead->source->label() }}
                                </span>
                                <span class="text-[10px] text-gray-400">
                                    {{ $lead->created_at?->diffForHumans(short: true) }}
                                </span>
                            </div>

                            <div class="mt-2 text-xs text-gray-500">
                                {{ $lead->assignee?->name ?? 'Unassigned' }}
                            </div>

                            @can('update', $lead)
                                <form method="POST" action="{{ route('leads.status', $lead) }}" class="mt-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status"
                                            onchange="this.form.submit()"
                                            class="w-full rounded border-gray-300 text-xs py-1">
                                        @foreach ($statuses as $option)
                                            <option value="{{ $option->value }}" @selected($lead->status === $option)>
                                                Move to {{ $option->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <noscript>
                                        <button type="submit" class="mt-1 text-xs text-gray-600 underline">Move</button>
                                    </noscript>
                                </form>
                            @endcan
                        </div>
                    @empty
                        <div class="text-xs text-gray-400 px-1 py-6 text-center border border-dashed border-gray-200 rounded-lg">
                            Nothing here
                        </div>
                    @endforelse
                </div>
            </div>
        @endforeach
    </div>
</div>
