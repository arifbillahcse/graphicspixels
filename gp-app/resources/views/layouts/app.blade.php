<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'GraphicsPixels') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 flex">
        @include('partials.sidebar')

        {{-- Backdrop, only while the sidebar is open on a small screen. --}}
        <div data-sidebar-backdrop class="hidden fixed inset-0 bg-black/40 z-30 lg:hidden"></div>

        <div class="flex-1 flex flex-col min-w-0">
            @include('partials.navbar')

            @isset($header)
                <header class="bg-white border-b border-gray-200">
                    <div class="px-4 sm:px-6 py-4">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Sidebar toggle for narrow screens. The sidebar is a plain element on
         desktop, so this only has to manage the small-screen overlay. --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var sidebar = document.querySelector('[data-sidebar]');
            var backdrop = document.querySelector('[data-sidebar-backdrop]');
            var toggle = document.querySelector('[data-sidebar-toggle]');

            if (!sidebar || !toggle) return;

            function setOpen(open) {
                sidebar.classList.toggle('hidden', !open);
                sidebar.classList.toggle('flex', open);
                if (backdrop) backdrop.classList.toggle('hidden', !open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            }

            toggle.addEventListener('click', function () {
                setOpen(sidebar.classList.contains('hidden'));
            });

            if (backdrop) {
                backdrop.addEventListener('click', function () { setOpen(false); });
            }

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') setOpen(false);
            });
        });
    </script>
</body>
</html>
