<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <a href="{{ route('leads.index') }}" class="text-xs text-gray-500 hover:text-gray-900">&larr; All leads</a>
                <h1 class="text-lg font-semibold text-gray-900">{{ $lead->name }}</h1>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $lead->status->badgeClasses() }}">
                    {{ $lead->status->label() }}
                </span>
                @can('update', $lead)
                    <a href="{{ route('leads.edit', $lead) }}"
                       class="px-3 py-1.5 rounded-md border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
                        Edit
                    </a>
                @endcan
                @can('create', App\Models\Order::class)
                    <a href="{{ route('leads.convert', $lead) }}"
                       class="px-3 py-1.5 rounded-md bg-[#C3009D] text-white text-sm hover:bg-[#C3009D]/90">
                        Convert to order
                    </a>
                @endcan
            </div>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Enquiry</h2>

                <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-xs text-gray-500">Email</dt>
                        <dd class="text-gray-900"><a href="mailto:{{ $lead->email }}" class="hover:text-[#C3009D]">{{ $lead->email }}</a></dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Phone</dt>
                        <dd class="text-gray-900">{{ $lead->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Website</dt>
                        <dd class="text-gray-900 break-all">{{ $lead->website ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Company</dt>
                        <dd class="text-gray-900">{{ $lead->company ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Service</dt>
                        <dd class="text-gray-900">{{ $lead->service ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Source</dt>
                        <dd class="text-gray-900">{{ $lead->source->label() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Received</dt>
                        <dd class="text-gray-900">{{ ($lead->submitted_at ?? $lead->created_at)?->format('d M Y, H:i') }}</dd>
                    </div>
                    @if ($lead->wp_entry_id)
                        <div>
                            <dt class="text-xs text-gray-500">WordPress entry</dt>
                            <dd class="text-gray-900">#{{ $lead->wp_entry_id }}</dd>
                        </div>
                    @endif
                </dl>

                @if ($lead->message)
                    <div class="mt-5 pt-5 border-t border-gray-100">
                        <div class="text-xs text-gray-500 mb-1">Message</div>
                        <p class="text-sm text-gray-800 whitespace-pre-line">{{ $lead->message }}</p>
                    </div>
                @endif

                @if ($lead->file_link)
                    <div class="mt-5 pt-5 border-t border-gray-100">
                        <div class="text-xs text-gray-500 mb-1">Cloud link supplied by the client</div>
                        <a href="{{ $lead->file_link }}" target="_blank" rel="noopener noreferrer"
                           class="text-sm text-[#C3009D] hover:underline break-all">{{ $lead->file_link }}</a>
                    </div>
                @endif
            </div>

            {{-- Attachments --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">
                    Attachments ({{ $lead->attachments->count() }})
                </h2>

                @forelse ($lead->attachments as $attachment)
                    <div class="flex items-center justify-between gap-3 py-2 border-b border-gray-100 last:border-0">
                        <div class="min-w-0">
                            <div class="text-sm text-gray-900 truncate">
                                {{ $attachment->filename ?? $attachment->source_url }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $attachment->humanSize() }}
                                @if ($attachment->status !== 'stored')
                                    &middot; <span class="text-amber-700">{{ ucfirst($attachment->status) }}</span>
                                    @if ($attachment->error)
                                        &middot; {{ $attachment->error }}
                                    @endif
                                @endif
                            </div>
                        </div>

                        @if ($attachment->isStored())
                            <a href="{{ route('leads.attachments.download', [$lead, $attachment]) }}"
                               class="shrink-0 px-3 py-1.5 rounded-md border border-gray-300 text-xs text-gray-700 hover:bg-gray-50">
                                Download
                            </a>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No files were attached to this enquiry.</p>
                @endforelse
            </div>

            {{-- Activity log --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Activity</h2>

                @can('update', $lead)
                    <form method="POST" action="{{ route('leads.notes.store', $lead) }}" class="mb-5">
                        @csrf
                        <label for="note" class="sr-only">Note</label>
                        <textarea name="note" id="note" rows="3" required
                                  placeholder="Log a call, an email, or anything worth remembering…"
                                  class="w-full rounded-md border-gray-300 text-sm">{{ old('note') }}</textarea>
                        <button type="submit"
                                class="mt-2 px-3 py-2 rounded-md bg-[#01015E] text-white text-sm hover:bg-[#01015E]/90">
                            Add note
                        </button>
                    </form>
                @endcan

                <ol class="space-y-3">
                    @forelse ($lead->activities as $activity)
                        <li class="flex gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-[#C3009D] mt-2 shrink-0"></div>
                            <div class="min-w-0">
                                <div class="text-sm text-gray-900">{{ $activity->summary() }}</div>
                                @if ($activity->note)
                                    <p class="text-sm text-gray-600 whitespace-pre-line mt-0.5">{{ $activity->note }}</p>
                                @endif
                                <div class="text-xs text-gray-400 mt-0.5">
                                    {{ $activity->actorName() }} &middot; {{ $activity->created_at?->diffForHumans() }}
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Nothing logged yet.</li>
                    @endforelse
                </ol>
            </div>
        </div>

        {{-- Sidebar actions --}}
        <div class="space-y-6">
            @can('update', $lead)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-sm font-semibold text-gray-900 mb-3">Stage</h2>
                    <form method="POST" action="{{ route('leads.status', $lead) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="w-full rounded-md border-gray-300 text-sm">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected($lead->status === $status)>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                                class="mt-2 w-full px-3 py-2 rounded-md bg-gray-900 text-white text-sm">
                            Update stage
                        </button>
                    </form>
                </div>
            @endcan

            @can('assign', $lead)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-sm font-semibold text-gray-900 mb-3">Owner</h2>
                    <form method="POST" action="{{ route('leads.assign', $lead) }}">
                        @csrf
                        @method('PATCH')
                        <select name="assigned_to" class="w-full rounded-md border-gray-300 text-sm">
                            <option value="">Unassigned</option>
                            @foreach ($assignees as $user)
                                <option value="{{ $user->id }}" @selected($lead->assigned_to === $user->id)>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                                class="mt-2 w-full px-3 py-2 rounded-md bg-gray-900 text-white text-sm">
                            Save owner
                        </button>
                    </form>
                </div>
            @endcan

            @can('delete', $lead)
                <div class="bg-white rounded-lg border border-red-200 p-6">
                    <h2 class="text-sm font-semibold text-gray-900 mb-1">Delete lead</h2>
                    <p class="text-xs text-gray-500 mb-3">This also removes its activity log and attachments.</p>
                    <form method="POST" action="{{ route('leads.destroy', $lead) }}"
                          onsubmit="return confirm('Delete this lead permanently?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full px-3 py-2 rounded-md border border-red-300 text-red-700 text-sm hover:bg-red-50">
                            Delete
                        </button>
                    </form>
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>
