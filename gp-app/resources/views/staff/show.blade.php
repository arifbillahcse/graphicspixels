<x-app-layout>
    <x-slot name="header">
        <div>
            @can('viewAny', App\Models\User::class)
                <a href="{{ route('staff.index') }}" class="text-xs text-gray-500 hover:text-gray-900">&larr; Staff directory</a>
            @endcan
            <h1 class="text-lg font-semibold text-gray-900">{{ $staff->name }}</h1>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Profile</h2>
                <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div><dt class="text-xs text-gray-500">Email</dt><dd class="text-gray-900 break-all">{{ $staff->email }}</dd></div>
                    <div><dt class="text-xs text-gray-500">Role</dt><dd class="text-gray-900">{{ $staff->primaryRole()?->label() ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-gray-500">Department</dt><dd class="text-gray-900">{{ $staff->department?->label() ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-gray-500">Job title</dt><dd class="text-gray-900">{{ $staff->job_title ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-gray-500">Reports to</dt><dd class="text-gray-900">{{ $staff->teamLeader?->name ?? '—' }}</dd></div>
                    <div><dt class="text-xs text-gray-500">Joined</dt><dd class="text-gray-900">{{ $staff->created_at?->format('d M Y') }}</dd></div>
                </dl>

                @if ($staff->teamMembers->isNotEmpty())
                    <div class="mt-5 pt-5 border-t border-gray-100">
                        <div class="text-xs text-gray-500 mb-1">Team of {{ $staff->teamMembers->count() }}</div>
                        <p class="text-sm text-gray-800">{{ $staff->teamMembers->pluck('name')->join(', ') }}</p>
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-gray-900">Current work</h2>
                    <span class="text-xs text-gray-500">{{ $completedThisMonth }} completed this month</span>
                </div>

                @forelse ($openBatches as $batch)
                    <div class="flex items-center justify-between gap-3 py-2 border-b border-gray-100 last:border-0">
                        <div class="min-w-0">
                            <span class="text-sm text-gray-900">{{ $batch->order->reference }}</span>
                            <span class="text-xs text-gray-500 ml-1">{{ $batch->label() }}</span>
                            <div class="text-xs text-gray-500">{{ number_format($batch->image_count) }} images</div>
                        </div>
                        <span class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium {{ $batch->status->badgeClasses() }}">
                            {{ $batch->status->label() }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No open batches.</p>
                @endforelse
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-4">Leave</h2>

                @forelse ($staff->leaveRequests as $leave)
                    <div class="flex items-center justify-between gap-3 py-2 border-b border-gray-100 last:border-0">
                        <div class="min-w-0">
                            <span class="text-sm text-gray-900">{{ $leave->range()->label() }}</span>
                            <div class="text-xs text-gray-500">
                                {{ $leave->type->label() }} &middot; {{ $leave->days() }} day{{ $leave->days() === 1 ? '' : 's' }}
                                @if ($leave->reviewer)
                                    &middot; by {{ $leave->reviewer->name }}
                                @endif
                            </div>
                        </div>
                        <span class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium {{ $leave->status->badgeClasses() }}">
                            {{ $leave->status->label() }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">No leave on record.</p>
                @endforelse
            </div>
        </div>

        @can('manage', $staff)
            <div>
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-sm font-semibold text-gray-900 mb-3">Organisation</h2>
                    <form method="POST" action="{{ route('staff.update', $staff) }}" class="space-y-3">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="job_title" class="block text-xs font-medium text-gray-500 mb-1">Job title</label>
                            <input type="text" name="job_title" id="job_title"
                                   value="{{ old('job_title', $staff->job_title) }}"
                                   class="w-full rounded-md border-gray-300 text-sm">
                        </div>

                        <div>
                            <label for="team_leader_id" class="block text-xs font-medium text-gray-500 mb-1">Reports to</label>
                            <select name="team_leader_id" id="team_leader_id" class="w-full rounded-md border-gray-300 text-sm">
                                <option value="">Nobody</option>
                                @foreach ($teamLeaders as $leader)
                                    <option value="{{ $leader->id }}" @selected($staff->team_leader_id === $leader->id)>
                                        {{ $leader->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="is_active" value="1" @checked($staff->is_active)
                                   class="rounded border-gray-300">
                            Active
                        </label>

                        <button type="submit" class="w-full px-3 py-2 rounded-md bg-gray-900 text-white text-sm">
                            Save
                        </button>
                    </form>
                </div>
            </div>
        @endcan
    </div>
</x-app-layout>
