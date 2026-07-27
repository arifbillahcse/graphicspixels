<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">Team Leader Dashboard</h1>
            <a href="{{ route('orders.queue') }}" class="text-sm text-[#C3009D] hover:underline">Open my queue</a>
        </div>
    </x-slot>

    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">{{ $queue->count() }}</div>
            <div class="text-xs text-gray-500 mt-0.5">Open orders assigned to me</div>
        </div>
        <div class="bg-white rounded-lg border {{ $unbatched > 0 ? 'border-amber-300 bg-amber-50' : 'border-gray-200' }} p-4">
            <div class="text-2xl font-semibold {{ $unbatched > 0 ? 'text-amber-700' : 'text-gray-900' }}">
                {{ $unbatched }}
            </div>
            <div class="text-xs {{ $unbatched > 0 ? 'text-amber-700' : 'text-gray-500' }} mt-0.5">
                Waiting to be split into batches
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="text-2xl font-semibold text-gray-900">
                {{ number_format($queue->sum('image_count')) }}
            </div>
            <div class="text-xs text-gray-500 mt-0.5">Images in my queue</div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
        <h2 class="text-sm font-semibold text-gray-900 mb-4">My queue</h2>

        @forelse ($queue as $order)
            @php($sla = $order->sla())
            <div class="flex flex-wrap items-center justify-between gap-3 py-3 border-b border-gray-100 last:border-0">
                <div class="min-w-0">
                    <a href="{{ route('orders.show', $order) }}" class="text-sm font-medium text-gray-900 hover:text-[#C3009D]">
                        {{ $order->reference }}
                    </a>
                    <div class="text-xs text-gray-500 truncate">
                        {{ $order->client?->displayName() }} &middot;
                        {{ number_format($order->image_count) }} images &middot;
                        {{ $order->service_type->label() }}
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    @if ($order->batches_count === 0)
                        <a href="{{ route('orders.show', $order) }}"
                           class="text-xs px-2 py-1 rounded border border-amber-300 text-amber-800 bg-amber-50 hover:bg-amber-100">
                            Split into batches
                        </a>
                    @else
                        <span class="text-xs text-gray-500">{{ $order->batches_count }} batches</span>
                    @endif

                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $order->status->badgeClasses() }}">
                        {{ $order->status->label() }}
                    </span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $sla->badgeClasses() }}">
                        {{ $sla->label() }}
                    </span>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500">No orders are assigned to you right now.</p>
        @endforelse
    </div>

    @include('partials.role-panel', [
        'summary' => 'Splits assigned orders into batches and distributes them across the editors in your team. Auto-assign hands each batch to whoever is carrying the least open work.',
        'upcoming' => [
            'Quality control sign-off, and rework coming back to your team',
            'Your team\'s delivery and defect rates',
        ],
    ])
</x-app-layout>
