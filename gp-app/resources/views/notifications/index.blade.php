@php use App\Support\NotificationCatalog; @endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">
                Notifications
                @if ($unread > 0)
                    <span class="ml-1 text-sm font-normal text-gray-500">({{ $unread }} unread)</span>
                @endif
            </h1>

            <div class="flex items-center gap-3">
                @if ($unread > 0)
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-900">
                            Mark all read
                        </button>
                    </form>
                @endif
                <a href="{{ route('notifications.preferences') }}" class="text-sm text-[#C3009D] hover:underline">
                    Settings
                </a>
            </div>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="bg-white rounded-lg border border-gray-200 divide-y divide-gray-100">
        @forelse ($notifications as $notification)
            @php($data = $notification->data)
            <a href="{{ route('notifications.read', $notification->id) }}"
               class="flex items-start gap-3 p-4 hover:bg-gray-50 {{ $notification->read_at ? '' : 'bg-[#C3009D]/5' }}">
                <span class="mt-1.5 w-2 h-2 rounded-full shrink-0 {{ $notification->read_at ? 'bg-transparent' : 'bg-[#C3009D]' }}"
                      aria-hidden="true"></span>

                <div class="min-w-0 flex-1">
                    <div class="text-sm {{ $notification->read_at ? 'text-gray-800' : 'font-medium text-gray-900' }}">
                        {{ $data['title'] ?? 'Notification' }}
                    </div>
                    @if (! empty($data['body']))
                        <p class="text-sm text-gray-600 mt-0.5">{{ $data['body'] }}</p>
                    @endif
                    <div class="text-xs text-gray-400 mt-1">
                        {{ NotificationCatalog::label($data['key'] ?? '') }}
                        &middot; {{ $notification->created_at?->diffForHumans() }}
                    </div>
                </div>
            </a>
        @empty
            <div class="p-10 text-center">
                <p class="text-sm text-gray-500">Nothing here yet.</p>
                <p class="text-xs text-gray-400 mt-1">
                    You will be told when work is assigned to you, or when something needs attention.
                </p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</x-app-layout>
