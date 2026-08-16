@php use App\Support\WorkloadLevel; @endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">Editing floor workload</h1>
            @can('viewAny', App\Models\User::class)
                <a href="{{ route('staff.index') }}" class="text-sm text-[#C3009D] hover:underline">Staff directory</a>
            @endcan
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="mb-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">{{ $editors->count() }}</div>
            <div class="text-xs text-gray-500 mt-0.5">Active editors</div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">{{ $totalOpen }}</div>
            <div class="text-xs text-gray-500 mt-0.5">Open batches</div>
        </div>
        <div class="bg-white rounded-lg border {{ $unassignedBatches > 0 ? 'border-amber-300 bg-amber-50' : 'border-gray-200' }} p-4">
            <div class="text-2xl font-semibold {{ $unassignedBatches > 0 ? 'text-amber-700' : 'text-gray-900' }}">
                {{ $unassignedBatches }}
            </div>
            <div class="text-xs {{ $unassignedBatches > 0 ? 'text-amber-700' : 'text-gray-500' }} mt-0.5">
                Unassigned batches
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">{{ $awayCount }}</div>
            <div class="text-xs text-gray-500 mt-0.5">Away today</div>
        </div>
    </div>

    @foreach ($teams as $teamName => $members)
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-semibold text-gray-900">{{ $teamName }}</h2>
                <span class="text-xs text-gray-500">
                    {{ $members->sum('open_batches_count') }} open across {{ $members->count() }}
                </span>
            </div>

            <div class="space-y-3">
                @foreach ($members as $editor)
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="w-48 shrink-0 min-w-0">
                            <a href="{{ route('staff.show', $editor) }}"
                               class="text-sm text-gray-900 hover:text-[#C3009D] truncate block">
                                {{ $editor->name }}
                            </a>
                            @if ($editor->is_on_leave)
                                <span class="text-[10px] uppercase tracking-wide text-gray-500">On leave today</span>
                            @endif
                        </div>

                        {{-- Load meter --}}
                        <div class="flex-1 min-w-[140px]">
                            <div class="h-2 rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full rounded-full
                                            {{ match ($editor->workload_level) {
                                                WorkloadLevel::HEAVY => 'bg-red-500',
                                                WorkloadLevel::STEADY => 'bg-amber-500',
                                                WorkloadLevel::LIGHT => 'bg-green-500',
                                                default => 'bg-gray-300',
                                            } }}"
                                     style="width: {{ WorkloadLevel::percent($editor->open_batches_count) }}%"></div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            @if ($editor->revision_count > 0)
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    {{ $editor->revision_count }} rework
                                </span>
                            @endif
                            <span class="text-xs text-gray-500 w-24 text-right">
                                {{ number_format($editor->outstanding_images) }} images
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium w-20 text-center
                                         {{ WorkloadLevel::badgeClasses($editor->workload_level) }}">
                                {{ $editor->open_batches_count }} {{ WorkloadLevel::label($editor->workload_level) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h2 class="text-sm font-semibold text-gray-900 mb-2">How to read this</h2>
        <ul class="space-y-1.5 text-sm text-gray-600">
            <li class="flex gap-2"><span class="text-[#C3009D]">&bull;</span>
                <span>Light is 1&ndash;2 open batches, steady 3&ndash;5, heavy {{ WorkloadLevel::HEAVY_THRESHOLD }} or more.</span></li>
            <li class="flex gap-2"><span class="text-[#C3009D]">&bull;</span>
                <span>Idle is grey rather than green: an editor with nothing to do is worth acting on too.</span></li>
            <li class="flex gap-2"><span class="text-[#C3009D]">&bull;</span>
                <span>Auto-assign skips anyone on approved leave, so people shown as away will not pick up new batches.</span></li>
        </ul>
    </div>
</x-app-layout>
