@php
    $user = auth()->user();
    $role = $user?->primaryRole();
@endphp

<nav class="bg-white border-b border-gray-200">
    <div class="px-6 py-3 flex items-center justify-between gap-4">
        <div class="min-w-0">
            <span class="text-sm text-gray-500">Signed in as</span>
            <span class="font-semibold text-gray-900">{{ $user?->name }}</span>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            @if ($role)
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-[#C3009D]/10 text-[#C3009D]">
                    {{ $role->label() }}
                </span>
            @endif

            @if ($user?->department)
                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                    {{ $user->department->label() }}
                </span>
            @endif

            <a href="{{ route('profile.edit') }}" class="text-sm text-gray-600 hover:text-gray-900">
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
