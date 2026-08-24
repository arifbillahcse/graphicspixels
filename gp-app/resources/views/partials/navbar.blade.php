@php
    $user = auth()->user();
    $role = $user?->primaryRole();
    // One count per page load; the composite index on (notifiable, read_at)
    // keeps it cheap.
    $unread = $user?->unreadNotifications()->count() ?? 0;
@endphp

<nav class="bg-white border-b border-gray-200">
    <div class="px-4 sm:px-6 py-3 flex items-center justify-between gap-3">
        <div class="min-w-0 flex items-center gap-3">
            {{-- Only shown on small screens, where the sidebar is collapsed. --}}
            <button type="button" data-sidebar-toggle aria-label="Show navigation" aria-expanded="false"
                    class="lg:hidden shrink-0 p-1.5 -ml-1 rounded-md text-gray-600 hover:bg-gray-100">
                <span aria-hidden="true" class="block w-5 h-0.5 bg-current mb-1"></span>
                <span aria-hidden="true" class="block w-5 h-0.5 bg-current mb-1"></span>
                <span aria-hidden="true" class="block w-5 h-0.5 bg-current"></span>
            </button>

            <div class="min-w-0 truncate">
                <span class="text-sm text-gray-500 hidden sm:inline">Signed in as</span>
                <span class="font-semibold text-gray-900">{{ $user?->name }}</span>
            </div>
        </div>

        <div class="flex items-center gap-2 sm:gap-3 shrink-0">
            @if ($role)
                <span class="hidden sm:inline px-2.5 py-1 rounded-full text-xs font-semibold bg-[#C3009D]/10 text-[#C3009D]">
                    {{ $role->label() }}
                </span>
            @endif

            @if ($user?->department)
                <span class="hidden md:inline px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                    {{ $user->department->label() }}
                </span>
            @endif

            {{-- Notification bell --}}
            <a href="{{ route('notifications.index') }}"
               class="relative p-1.5 rounded-md text-gray-600 hover:bg-gray-100"
               aria-label="Notifications{{ $unread > 0 ? ", {$unread} unread" : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 17h5l-1.4-1.4A2 2 0 0 1 18 14.2V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />
                </svg>
                @if ($unread > 0)
                    <span class="absolute -top-0.5 -right-0.5 min-w-[1.1rem] h-[1.1rem] px-1 rounded-full
                                 bg-[#C3009D] text-white text-[10px] font-bold flex items-center justify-center">
                        {{ $unread > 99 ? '99+' : $unread }}
                    </span>
                @endif
            </a>

            <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 hover:text-gray-900 hidden sm:inline">
                Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                    Log out
                </button>
            </form>
        </div>
    </div>
</nav>
