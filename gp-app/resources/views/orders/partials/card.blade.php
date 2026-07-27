@php
    $sla = $order->sla();
    $canMove = auth()->user()->can('update', $order);
@endphp

<div class="bg-white rounded-lg border border-gray-200 p-3 {{ $canMove ? 'cursor-move' : '' }}"
     @if ($canMove) draggable="true" data-order-card data-order-id="{{ $order->id }}" @endif>

    <div class="flex items-start justify-between gap-2">
        <a href="{{ route('orders.show', $order) }}"
           class="font-medium text-sm text-gray-900 hover:text-[#C3009D]">
            {{ $order->reference }}
        </a>
        @if ($order->rush)
            <span class="shrink-0 text-[10px] font-bold uppercase tracking-wide bg-red-100 text-red-700 px-1.5 py-0.5 rounded">
                Rush
            </span>
        @endif
    </div>

    <div class="text-xs text-gray-600 truncate mt-0.5">{{ $order->client?->displayName() }}</div>

    <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
        <span>{{ number_format($order->image_count) }} images</span>
        <span>{{ $order->service_type->label() }}</span>
    </div>

    {{-- SLA countdown: green over 12h, amber 4-12h, red under 4h --}}
    <div class="mt-2 flex items-center justify-between gap-2">
        <span class="px-2 py-0.5 rounded-full text-[11px] font-medium {{ $sla->badgeClasses() }}">
            {{ $sla->label() }}
        </span>
        <span class="text-[11px] text-gray-400">
            {{ $order->deadline?->format('d M H:i') }}
        </span>
    </div>

    <div class="mt-2 pt-2 border-t border-gray-100 flex items-center justify-between text-xs">
        <span class="text-gray-600 truncate">
            {{ $order->teamLeader?->name ?? 'Unassigned' }}
        </span>
        @if ($order->batches_count)
            <span class="text-gray-400 shrink-0">{{ $order->batches_count }} batches</span>
        @endif
    </div>

    {{-- Works without JavaScript, and is the accessible way to move a card. --}}
    @if ($canMove)
        <form method="POST" action="{{ route('orders.status', $order) }}" class="mt-2">
            @csrf
            @method('PATCH')
            <select name="status" onchange="this.form.submit()"
                    class="w-full rounded border-gray-300 text-xs py-1">
                @foreach ($statuses as $option)
                    <option value="{{ $option->value }}" @selected($order->status === $option)>
                        Move to {{ $option->label() }}
                    </option>
                @endforeach
            </select>
            <noscript>
                <button type="submit" class="mt-1 text-xs text-gray-600 underline">Move</button>
            </noscript>
        </form>
    @endif
</div>
