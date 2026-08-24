<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('notifications.index') }}" class="text-xs text-gray-500 hover:text-gray-900">&larr; Notifications</a>
            <h1 class="text-lg font-semibold text-gray-900">Notification settings</h1>
        </div>
    </x-slot>

    @include('partials.flash')

    <form method="POST" action="{{ route('notifications.preferences.update') }}" class="max-w-3xl">
        @csrf
        @method('PUT')

        @foreach ($grouped as $group => $types)
            <div class="bg-white rounded-lg border border-gray-200 mb-4 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                    <h2 class="text-sm font-semibold text-gray-900">{{ $group }}</h2>
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach ($types as $key => $type)
                        @php
                            $row = $stored->get($key);
                            $emailOn = $row ? $row->email : $type['email'];
                            $inAppOn = $row ? $row->in_app : $type['in_app'];
                        @endphp

                        <div class="flex flex-wrap items-start justify-between gap-4 p-4">
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-gray-900">{{ $type['label'] }}</div>
                                <p class="text-sm text-gray-500 mt-0.5">{{ $type['description'] }}</p>
                            </div>

                            <div class="flex items-center gap-4 shrink-0">
                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" name="in_app[]" value="{{ $key }}"
                                           @checked($inAppOn) class="rounded border-gray-300">
                                    In app
                                </label>
                                <label class="flex items-center gap-2 text-sm text-gray-700">
                                    <input type="checkbox" name="email[]" value="{{ $key }}"
                                           @checked($emailOn) class="rounded border-gray-300">
                                    Email
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex items-center gap-3">
            <button type="submit" class="px-4 py-2 rounded-md bg-[#01015E] text-white text-sm hover:bg-[#01015E]/90">
                Save settings
            </button>
            <span class="text-xs text-gray-500">
                Switching everything off for a type means you will not hear about it at all.
            </span>
        </div>
    </form>
</x-app-layout>
