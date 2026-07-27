@php
    $sla = $order->sla();
    $canUpdate = auth()->user()->can('update', $order);
    $canAssign = auth()->user()->can('assign', $order);
    $canBatch = auth()->user()->can('manageBatches', $order);
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <a href="{{ route('orders.index') }}" class="text-xs text-gray-500 hover:text-gray-900">&larr; Production board</a>
                <h1 class="text-lg font-semibold text-gray-900">
                    {{ $order->reference }}
                    @if ($order->rush)
                        <span class="ml-2 text-[10px] font-bold uppercase tracking-wide bg-red-100 text-red-700 px-1.5 py-0.5 rounded align-middle">Rush</span>
                    @endif
                </h1>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $sla->badgeClasses() }}">
                    {{ $sla->label() }}
                </span>
                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $order->status->badgeClasses() }}">
                    {{ $order->status->label() }}
                </span>
            </div>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            {{-- Order detail --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Order</h2>

                <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-xs text-gray-500">Client</dt>
                        <dd class="text-gray-900">{{ $order->client?->displayName() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Rate tier</dt>
                        <dd class="text-gray-900">{{ $order->client?->rate_tier->label() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Service</dt>
                        <dd class="text-gray-900">{{ $order->service_type->label() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Images</dt>
                        <dd class="text-gray-900">{{ number_format($order->image_count) }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Received</dt>
                        <dd class="text-gray-900">{{ $order->received_at?->format('d M Y, H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Deadline</dt>
                        <dd class="text-gray-900">
                            {{ $order->deadline?->format('d M Y, H:i') }}
                            <span class="text-xs text-gray-500">({{ $sla->percentElapsed() }}% elapsed)</span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Team leader</dt>
                        <dd class="text-gray-900">{{ $order->teamLeader?->name ?? 'Unassigned' }}</dd>
                    </div>
                    @if ($order->completed_at)
                        <div>
                            <dt class="text-xs text-gray-500">Delivered</dt>
                            <dd class="text-gray-900">{{ $order->completed_at->format('d M Y, H:i') }}</dd>
                        </div>
                    @endif
                    @if ($order->lead)
                        <div>
                            <dt class="text-xs text-gray-500">Converted from</dt>
                            <dd><a href="{{ route('leads.show', $order->lead) }}" class="text-[#C3009D] hover:underline">Lead #{{ $order->lead->id }}</a></dd>
                        </div>
                    @endif
                </dl>

                @if ($order->notes)
                    <div class="mt-5 pt-5 border-t border-gray-100">
                        <div class="text-xs text-gray-500 mb-1">Brief</div>
                        <p class="text-sm text-gray-800 whitespace-pre-line">{{ $order->notes }}</p>
                    </div>
                @endif

                <div class="mt-5 pt-5 border-t border-gray-100 grid sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <div class="text-xs text-gray-500 mb-1">File intake</div>
                        @if ($order->file_intake_link)
                            <a href="{{ $order->file_intake_link }}" target="_blank" rel="noopener noreferrer"
                               class="text-[#C3009D] hover:underline break-all">{{ $order->file_intake_link }}</a>
                        @else
                            <span class="text-gray-400">Not supplied</span>
                        @endif
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Delivery</div>
                        @if ($order->delivery_link)
                            <a href="{{ $order->delivery_link }}" target="_blank" rel="noopener noreferrer"
                               class="text-[#C3009D] hover:underline break-all">{{ $order->delivery_link }}</a>
                        @else
                            <span class="text-gray-400">Not uploaded yet</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Batches --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">
                        Batches ({{ $order->batches->count() }})
                    </h2>
                    <span class="text-xs text-gray-500">
                        {{ number_format($order->image_count - $order->unbatchedImages()) }} of
                        {{ number_format($order->image_count) }} images batched
                    </span>
                </div>

                @forelse ($order->batches as $batch)
                    <div class="py-3 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <span class="text-sm font-medium text-gray-900">{{ $batch->label() }}</span>
                                <span class="text-xs text-gray-500 ml-2">{{ number_format($batch->image_count) }} images</span>
                            </div>
                            <span class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium {{ $batch->status->badgeClasses() }}">
                                {{ $batch->status->label() }}
                            </span>
                        </div>

                        <div class="mt-2 flex flex-wrap items-center gap-2">
                            @can('assign', $batch)
                                <form method="POST" action="{{ route('batches.assign', $batch) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="editor_id" class="rounded border-gray-300 text-xs py-1">
                                        <option value="">Unassigned</option>
                                        @foreach ($editors as $editor)
                                            <option value="{{ $editor->id }}" @selected($batch->editor_id === $editor->id)>
                                                {{ $editor->name }} ({{ $editor->open_batches_count }} open)
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="text-xs px-2 py-1 rounded border border-gray-300 hover:bg-gray-50">
                                        Save
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-500">{{ $batch->editor?->name ?? 'Unassigned' }}</span>
                            @endcan

                            @can('update', $batch)
                                <form method="POST" action="{{ route('batches.status', $batch) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="rounded border-gray-300 text-xs py-1">
                                        @foreach (App\Enums\BatchStatus::cases() as $option)
                                            <option value="{{ $option->value }}" @selected($batch->status === $option)>
                                                {{ $option->label() }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="text-xs px-2 py-1 rounded border border-gray-300 hover:bg-gray-50">
                                        Update
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">This order has not been split into batches yet.</p>
                @endforelse

                {{-- Split dialog --}}
                @if ($canBatch && $order->unbatchedImages() > 0)
                    <form method="POST" action="{{ route('orders.batches.store', $order) }}"
                          class="mt-5 pt-5 border-t border-gray-100">
                        @csrf
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">Create batches</h3>
                        <p class="text-xs text-gray-500 mb-3">
                            {{ number_format($order->unbatchedImages()) }} images still to allocate.
                        </p>

                        <div class="flex flex-wrap items-end gap-3">
                            <div>
                                <label for="mode" class="block text-xs font-medium text-gray-500 mb-1">Split by</label>
                                <select name="mode" id="mode" class="rounded-md border-gray-300 text-sm">
                                    <option value="count">Number of batches</option>
                                    <option value="size">Images per batch</option>
                                </select>
                            </div>

                            <div>
                                <label for="batch_count" class="block text-xs font-medium text-gray-500 mb-1">How many</label>
                                <input type="number" name="batch_count" id="batch_count" min="1" value="{{ old('batch_count', 2) }}"
                                       class="w-28 rounded-md border-gray-300 text-sm">
                            </div>

                            <div>
                                <label for="batch_size" class="block text-xs font-medium text-gray-500 mb-1">Or size</label>
                                <input type="number" name="batch_size" id="batch_size" min="1" value="{{ old('batch_size') }}"
                                       class="w-28 rounded-md border-gray-300 text-sm">
                            </div>

                            <label class="flex items-center gap-2 text-sm text-gray-700 pb-2">
                                <input type="checkbox" name="auto_assign" value="1" checked class="rounded border-gray-300">
                                Auto-assign to editors
                            </label>

                            <button type="submit" class="px-3 py-2 rounded-md bg-[#01015E] text-white text-sm hover:bg-[#01015E]/90">
                                Create
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">
                            Auto-assign gives each batch to whichever active editor is carrying the least open work.
                        </p>
                    </form>
                @endif
            </div>

            {{-- Notes --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Notes &amp; history</h2>

                @can('addNote', $order)
                    <form method="POST" action="{{ route('orders.notes.store', $order) }}" class="mb-5">
                        @csrf
                        <label for="note" class="sr-only">Note</label>
                        <textarea name="note" id="note" rows="3" required
                                  placeholder="Anything the next person on this order should know…"
                                  class="w-full rounded-md border-gray-300 text-sm">{{ old('note') }}</textarea>
                        <button type="submit" class="mt-2 px-3 py-2 rounded-md bg-[#01015E] text-white text-sm hover:bg-[#01015E]/90">
                            Add note
                        </button>
                    </form>
                @endcan

                <ol class="space-y-3">
                    @forelse ($order->notes as $note)
                        <li class="flex gap-3">
                            <div class="w-1.5 h-1.5 rounded-full bg-[#C3009D] mt-2 shrink-0"></div>
                            <div class="min-w-0">
                                <p class="text-sm text-gray-800 whitespace-pre-line">{{ $note->note }}</p>
                                <div class="text-xs text-gray-400 mt-0.5">
                                    {{ $note->actorName() }}
                                    @if ($note->batch)
                                        &middot; {{ $note->batch->label() }}
                                    @endif
                                    &middot; {{ $note->created_at?->diffForHumans() }}
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500">Nothing logged yet.</li>
                    @endforelse
                </ol>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            @if ($canUpdate)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-sm font-semibold text-gray-900 mb-3">Stage</h2>
                    <form method="POST" action="{{ route('orders.status', $order) }}">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="w-full rounded-md border-gray-300 text-sm">
                            @foreach ($statuses as $status)
                                <option value="{{ $status->value }}" @selected($order->status === $status)>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="mt-2 w-full px-3 py-2 rounded-md bg-gray-900 text-white text-sm">
                            Update stage
                        </button>
                    </form>
                </div>
            @endif

            @if ($canAssign)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-sm font-semibold text-gray-900 mb-3">Team leader</h2>
                    <form method="POST" action="{{ route('orders.assign', $order) }}">
                        @csrf
                        @method('PATCH')
                        <select name="team_leader_id" class="w-full rounded-md border-gray-300 text-sm">
                            <option value="">Unassigned</option>
                            @foreach ($teamLeaders as $leader)
                                <option value="{{ $leader->id }}" @selected($order->team_leader_id === $leader->id)>
                                    {{ $leader->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="mt-2 w-full px-3 py-2 rounded-md bg-gray-900 text-white text-sm">
                            Save
                        </button>
                    </form>
                </div>
            @endif

            @if ($canUpdate)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-sm font-semibold text-gray-900 mb-3">Links &amp; deadline</h2>
                    <form method="POST" action="{{ route('orders.update', $order) }}" class="space-y-3">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="deadline" class="block text-xs font-medium text-gray-500 mb-1">Deadline</label>
                            <input type="datetime-local" name="deadline" id="deadline"
                                   value="{{ old('deadline', $order->deadline?->format('Y-m-d\TH:i')) }}"
                                   class="w-full rounded-md border-gray-300 text-sm">
                        </div>

                        <div>
                            <label for="file_intake_link" class="block text-xs font-medium text-gray-500 mb-1">File intake link</label>
                            <input type="text" name="file_intake_link" id="file_intake_link"
                                   value="{{ old('file_intake_link', $order->file_intake_link) }}"
                                   class="w-full rounded-md border-gray-300 text-sm">
                        </div>

                        <div>
                            <label for="delivery_link" class="block text-xs font-medium text-gray-500 mb-1">Delivery link</label>
                            <input type="text" name="delivery_link" id="delivery_link"
                                   value="{{ old('delivery_link', $order->delivery_link) }}"
                                   class="w-full rounded-md border-gray-300 text-sm">
                        </div>

                        <div>
                            <label for="brief" class="block text-xs font-medium text-gray-500 mb-1">Brief</label>
                            <textarea name="notes" id="brief" rows="3"
                                      class="w-full rounded-md border-gray-300 text-sm">{{ old('notes', $order->notes) }}</textarea>
                        </div>

                        <button type="submit" class="w-full px-3 py-2 rounded-md bg-gray-900 text-white text-sm">
                            Save changes
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
