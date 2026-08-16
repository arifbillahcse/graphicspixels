<x-app-layout>
    <x-slot name="header">
        <h1 class="text-lg font-semibold text-gray-900">Leave</h1>
    </x-slot>

    @include('partials.flash')

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            @if ($toDecide->isNotEmpty())
                <div class="bg-white rounded-lg border border-amber-200 p-6">
                    <h2 class="text-sm font-semibold text-gray-900 mb-4">
                        Awaiting your decision ({{ $toDecide->count() }})
                    </h2>

                    @foreach ($toDecide as $leave)
                        <div class="py-3 border-b border-gray-100 last:border-0">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <span class="text-sm font-medium text-gray-900">{{ $leave->user->name }}</span>
                                    <div class="text-xs text-gray-500">
                                        {{ $leave->type->label() }} &middot; {{ $leave->range()->label() }}
                                        &middot; {{ $leave->days() }} day{{ $leave->days() === 1 ? '' : 's' }}
                                    </div>
                                    @if ($leave->reason)
                                        <p class="text-sm text-gray-700 mt-1">{{ $leave->reason }}</p>
                                    @endif
                                </div>

                                @can('decide', $leave)
                                    <div class="flex items-center gap-2 shrink-0">
                                        <form method="POST" action="{{ route('leave.approve', $leave) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-md bg-green-700 text-white text-xs hover:bg-green-800">
                                                Approve
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('leave.deny', $leave) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                    class="px-3 py-1.5 rounded-md border border-red-300 text-red-700 text-xs hover:bg-red-50">
                                                Deny
                                            </button>
                                        </form>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">My leave</h2>

                @forelse ($mine as $leave)
                    <div class="flex flex-wrap items-center justify-between gap-3 py-3 border-b border-gray-100 last:border-0">
                        <div class="min-w-0">
                            <span class="text-sm text-gray-900">{{ $leave->range()->label() }}</span>
                            <div class="text-xs text-gray-500">
                                {{ $leave->type->label() }} &middot; {{ $leave->days() }} day{{ $leave->days() === 1 ? '' : 's' }}
                                @if ($leave->review_note)
                                    &middot; &ldquo;{{ $leave->review_note }}&rdquo;
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $leave->status->badgeClasses() }}">
                                {{ $leave->status->label() }}
                            </span>
                            @can('cancel', $leave)
                                <form method="POST" action="{{ route('leave.cancel', $leave) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-xs text-gray-500 hover:text-gray-900 underline">
                                        Cancel
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">You have not requested any leave.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-3">Request leave</h2>
                <form method="POST" action="{{ route('leave.store') }}" class="space-y-3">
                    @csrf

                    <div>
                        <label for="type" class="block text-xs font-medium text-gray-500 mb-1">Type</label>
                        <select name="type" id="type" class="w-full rounded-md border-gray-300 text-sm">
                            @foreach ($types as $type)
                                <option value="{{ $type->value }}" @selected(old('type') === $type->value)>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="starts_on" class="block text-xs font-medium text-gray-500 mb-1">From</label>
                        <input type="date" name="starts_on" id="starts_on" required
                               value="{{ old('starts_on') }}" class="w-full rounded-md border-gray-300 text-sm">
                    </div>

                    <div>
                        <label for="ends_on" class="block text-xs font-medium text-gray-500 mb-1">To</label>
                        <input type="date" name="ends_on" id="ends_on" required
                               value="{{ old('ends_on') }}" class="w-full rounded-md border-gray-300 text-sm">
                    </div>

                    <div>
                        <label for="reason" class="block text-xs font-medium text-gray-500 mb-1">Reason</label>
                        <textarea name="reason" id="reason" rows="3"
                                  class="w-full rounded-md border-gray-300 text-sm">{{ old('reason') }}</textarea>
                    </div>

                    <button type="submit" class="w-full px-3 py-2 rounded-md bg-[#01015E] text-white text-sm hover:bg-[#01015E]/90">
                        Submit request
                    </button>
                </form>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-1">Away this week</h2>
                <p class="text-xs text-gray-500 mb-3">{{ $week->label() }}</p>

                @forelse ($away as $leave)
                    <div class="py-2 border-b border-gray-100 last:border-0">
                        <div class="text-sm text-gray-900">{{ $leave->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $leave->range()->label() }}</div>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Nobody is away this week.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
