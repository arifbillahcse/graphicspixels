@php($sla = $batch->order->sla())

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <a href="{{ route('qc.queue') }}" class="text-xs text-gray-500 hover:text-gray-900">&larr; QC queue</a>
                <h1 class="text-lg font-semibold text-gray-900">
                    {{ $batch->order->reference }} &middot; {{ $batch->label() }}
                </h1>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $sla->badgeClasses() }}">
                {{ $sla->label() }}
            </span>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            {{-- What is being reviewed --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Under review</h2>
                <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="text-xs text-gray-500">Client</dt>
                        <dd class="text-gray-900">{{ $batch->order->client?->displayName() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Service</dt>
                        <dd class="text-gray-900">{{ $batch->order->service_type->label() }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Editor</dt>
                        <dd class="text-gray-900">{{ $batch->editor?->name ?? 'Unassigned' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Images</dt>
                        <dd class="text-gray-900">{{ number_format($batch->image_count) }}</dd>
                    </div>
                </dl>

                @if ($batch->order->file_intake_link)
                    <div class="mt-4 pt-4 border-t border-gray-100 text-sm">
                        <span class="text-xs text-gray-500">Files: </span>
                        <a href="{{ $batch->order->file_intake_link }}" target="_blank" rel="noopener noreferrer"
                           class="text-[#C3009D] hover:underline break-all">{{ $batch->order->file_intake_link }}</a>
                    </div>
                @endif

                @if ($batch->order->notes)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="text-xs text-gray-500 mb-1">Brief</div>
                        <p class="text-sm text-gray-800 whitespace-pre-line">{{ $batch->order->notes }}</p>
                    </div>
                @endif
            </div>

            {{-- Approve: checklist lives in this form so ticks are recorded --}}
            <form method="POST" action="{{ route('qc.approve', $review) }}"
                  class="bg-white rounded-lg border border-gray-200 p-6">
                @csrf

                <h2 class="text-sm font-semibold text-gray-900 mb-1">
                    Checklist &mdash; {{ $batch->order->service_type->label() }}
                </h2>
                <p class="text-xs text-gray-500 mb-4">
                    Ticks are recorded against this review. They do not block the decision.
                </p>

                <div class="space-y-2">
                    @foreach ($checklist as $item)
                        <label class="flex items-start gap-2 text-sm text-gray-800">
                            <input type="checkbox" name="checklist[]" value="{{ $item }}"
                                   class="mt-0.5 rounded border-gray-300">
                            <span>{{ $item }}</span>
                        </label>
                    @endforeach
                </div>

                @can('approve', $review)
                    <button type="submit"
                            class="mt-5 w-full px-4 py-2 rounded-md bg-green-700 text-white text-sm font-medium hover:bg-green-800">
                        Approve batch
                    </button>
                @endcan
            </form>

            {{-- Reject --}}
            @can('reject', $review)
                <form method="POST" action="{{ route('qc.reject', $review) }}"
                      class="bg-white rounded-lg border border-red-200 p-6">
                    @csrf

                    <h2 class="text-sm font-semibold text-gray-900 mb-1">Reject and send back</h2>
                    <p class="text-xs text-gray-500 mb-4">
                        The batch returns to {{ $batch->editor?->name ?? 'the editor' }} for revision. Give at least
                        one finding.
                    </p>

                    @for ($i = 0; $i < 3; $i++)
                        <div class="flex flex-wrap gap-2 mb-3">
                            <input type="text" name="comments[{{ $i }}][comment]"
                                   placeholder="{{ $i === 0 ? 'What needs fixing?' : 'Another finding (optional)' }}"
                                   class="flex-1 min-w-[220px] rounded-md border-gray-300 text-sm">
                            <select name="comments[{{ $i }}][severity]" class="rounded-md border-gray-300 text-sm">
                                @foreach ($severities as $severity)
                                    <option value="{{ $severity->value }}" @selected($severity->value === 'blocker' && $i === 0)>
                                        {{ $severity->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endfor

                    <button type="submit"
                            class="w-full px-4 py-2 rounded-md bg-red-700 text-white text-sm font-medium hover:bg-red-800">
                        Reject batch
                    </button>
                </form>
            @endcan
        </div>

        {{-- History --}}
        <div class="space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-3">Review history</h2>

                @forelse ($history as $past)
                    <div class="py-3 border-b border-gray-100 last:border-0">
                        <div class="flex items-center justify-between gap-2">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $past->outcome->badgeClasses() }}">
                                {{ $past->outcome->label() }}
                            </span>
                            <span class="text-xs text-gray-400">{{ $past->completed_at?->diffForHumans() }}</span>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $past->reviewer?->name ?? 'System' }}
                        </div>

                        @foreach ($past->comments as $comment)
                            <div class="mt-2 flex gap-2">
                                <span class="shrink-0 px-1.5 py-0.5 rounded text-[10px] font-semibold uppercase {{ $comment->severity->badgeClasses() }}">
                                    {{ $comment->severity->label() }}
                                </span>
                                <span class="text-xs text-gray-700">{{ $comment->comment }}</span>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="text-sm text-gray-500">This is the first review of this batch.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
