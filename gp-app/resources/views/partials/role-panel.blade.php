@php
    // $summary (string) and $upcoming (array of strings) are supplied by the
    // including dashboard view.
    $user = auth()->user();
    $permissions = $user->getAllPermissions()->pluck('name')->sort()->values();
@endphp

<div class="grid gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 bg-white rounded-lg border border-gray-200 p-6">
        <h2 class="text-base font-semibold text-gray-900">Phase 1 &mdash; foundation only</h2>
        <p class="mt-2 text-sm text-gray-600">{{ $summary }}</p>

        <h3 class="mt-6 text-xs font-semibold uppercase tracking-wide text-gray-400">
            Arriving in later phases
        </h3>
        <ul class="mt-3 space-y-2">
            @foreach ($upcoming as $item)
                <li class="flex gap-2 text-sm text-gray-700">
                    <span class="text-[#C3009D]">&bull;</span>
                    <span>{{ $item }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-400">
            Your permissions ({{ $permissions->count() }})
        </h3>

        @if ($permissions->isEmpty())
            <p class="mt-3 text-sm text-gray-500">No permissions assigned.</p>
        @else
            <ul class="mt-3 space-y-1">
                @foreach ($permissions as $permission)
                    <li class="text-xs font-mono text-gray-600">{{ $permission }}</li>
                @endforeach
            </ul>
        @endif

        @if ($user->teamLeader)
            <p class="mt-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
                Reports to <span class="font-medium text-gray-700">{{ $user->teamLeader->name }}</span>
            </p>
        @endif

        @if ($user->teamMembers->isNotEmpty())
            <p class="mt-4 pt-4 border-t border-gray-100 text-xs text-gray-500">
                Team of {{ $user->teamMembers->count() }}:
                <span class="font-medium text-gray-700">{{ $user->teamMembers->pluck('name')->join(', ') }}</span>
            </p>
        @endif
    </div>
</div>
