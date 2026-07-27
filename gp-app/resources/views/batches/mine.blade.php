<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">My batches</h1>
            <span class="text-sm text-gray-500">{{ $openCount }} open</span>
        </div>
    </x-slot>

    @include('partials.flash')

    @forelse ($batches as $batch)
        @php($sla = $batch->order->sla())

        <div class="bg-white rounded-lg border border-gray-200 p-5 mb-4
                    {{ $batch->status === App\Enums\BatchStatus::Revision ? 'border-orange-300 bg-orange-50/40' : '' }}">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="font-medium text-gray-900">{{ $batch->order->reference }}</span>
                        <span class="text-sm text-gray-500">&middot; {{ $batch->label() }}</span>
                        @if ($batch->order->rush)
                            <span class="text-[10px] font-bold uppercase tracking-wide bg-red-100 text-red-700 px-1.5 py-0.5 rounded">Rush</span>
                        @endif
                    </div>
                    <div class="text-sm text-gray-600 mt-0.5">
                        {{ number_format($batch->image_count) }} images &middot;
                        {{ $batch->order->service_type->label() }}
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $sla->badgeClasses() }}">
                        {{ $sla->label() }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $batch->status->badgeClasses() }}">
                        {{ $batch->status->label() }}
                    </span>
                </div>
            </div>

            @if ($batch->order->file_intake_link)
                <div class="mt-3 text-sm">
                    <span class="text-xs text-gray-500">Files: </span>
                    <a href="{{ $batch->order->file_intake_link }}" target="_blank" rel="noopener noreferrer"
                       class="text-[#C3009D] hover:underline break-all">{{ $batch->order->file_intake_link }}</a>
                </div>
            @endif

            @if ($batch->order->notes)
                <p class="mt-3 text-sm text-gray-700 whitespace-pre-line">{{ $batch->order->notes }}</p>
            @endif

            @php($nextSteps = $batch->status->editorCanMoveTo())

            <div class="mt-4 flex flex-wrap items-center gap-2">
                @forelse ($nextSteps as $next)
                    <form method="POST" action="{{ route('batches.status', $batch) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $next->value }}">
                        <button type="submit"
                                class="px-3 py-2 rounded-md bg-[#01015E] text-white text-sm hover:bg-[#01015E]/90">
                            Mark {{ $next->label() }}
                        </button>
                    </form>
                @empty
                    <span class="text-sm text-gray-500">
                        Nothing to do here — this batch is with {{ $batch->status === App\Enums\BatchStatus::ReadyForQc ? 'quality control' : 'the team' }}.
                    </span>
                @endforelse
            </div>

            <details class="mt-4">
                <summary class="text-xs text-gray-500 cursor-pointer hover:text-gray-900">Add a note</summary>
                <form method="POST" action="{{ route('batches.notes.store', $batch) }}" class="mt-2">
                    @csrf
                    <textarea name="note" rows="2" required
                              placeholder="Anything worth flagging on this batch…"
                              class="w-full rounded-md border-gray-300 text-sm"></textarea>
                    <button type="submit" class="mt-2 px-3 py-1.5 rounded-md border border-gray-300 text-sm hover:bg-gray-50">
                        Save note
                    </button>
                </form>
            </details>
        </div>
    @empty
        <div class="bg-white rounded-lg border border-gray-200 p-10 text-center">
            <p class="text-sm text-gray-500">No batches are assigned to you right now.</p>
        </div>
    @endforelse
</x-app-layout>
