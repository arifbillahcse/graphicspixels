<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-gray-900">
                {{ ($isQueue ?? false) ? 'My production queue' : 'Production board' }}
            </h1>
            <div class="flex items-center gap-2 text-sm">
                @if ($isQueue ?? false)
                    <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-900">All orders</a>
                @else
                    <a href="{{ route('orders.queue') }}" class="text-gray-500 hover:text-gray-900">My queue</a>
                @endif
            </div>
        </div>
    </x-slot>

    @include('partials.flash')

    {{-- Filters --}}
    <form method="GET" class="bg-white rounded-lg border border-gray-200 p-4 mb-6 flex flex-wrap items-end gap-3">
        <div class="flex-1 min-w-[200px]">
            <label for="q" class="block text-xs font-medium text-gray-500 mb-1">Search</label>
            <input type="text" name="q" id="q" value="{{ $filters['q'] }}"
                   placeholder="Reference, client or company"
                   class="w-full rounded-md border-gray-300 text-sm">
        </div>

        <div>
            <label for="service_type" class="block text-xs font-medium text-gray-500 mb-1">Service</label>
            <select name="service_type" id="service_type" class="rounded-md border-gray-300 text-sm">
                <option value="">All</option>
                @foreach ($serviceTypes as $service)
                    <option value="{{ $service->value }}" @selected($filters['service_type'] === $service->value)>
                        {{ $service->label() }}
                    </option>
                @endforeach
            </select>
        </div>

        @unless ($isQueue ?? false)
            <div>
                <label for="team_leader" class="block text-xs font-medium text-gray-500 mb-1">Team leader</label>
                <select name="team_leader" id="team_leader" class="rounded-md border-gray-300 text-sm">
                    <option value="">Anyone</option>
                    <option value="unassigned" @selected($filters['team_leader'] === 'unassigned')>Unassigned</option>
                    @foreach ($teamLeaders as $leader)
                        <option value="{{ $leader->id }}" @selected($filters['team_leader'] === (string) $leader->id)>
                            {{ $leader->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endunless

        <label class="flex items-center gap-2 text-sm text-gray-700 pb-2">
            <input type="checkbox" name="rush" value="1" @checked($filters['rush']) class="rounded border-gray-300">
            Rush only
        </label>

        <label class="flex items-center gap-2 text-sm text-gray-700 pb-2">
            <input type="checkbox" name="at_risk" value="1" @checked($filters['at_risk']) class="rounded border-gray-300">
            At risk
        </label>

        <button type="submit" class="px-3 py-2 rounded-md bg-gray-900 text-white text-sm">Filter</button>
        <a href="{{ ($isQueue ?? false) ? route('orders.queue') : route('orders.index') }}"
           class="px-3 py-2 text-sm text-gray-500 hover:text-gray-900">Reset</a>
    </form>

    {{-- Board --}}
    <div class="overflow-x-auto pb-4">
        <div class="flex gap-4 min-w-max">
            @foreach ($statuses as $status)
                @php($columnOrders = $board->get($status->value, collect()))

                <div class="w-72 shrink-0">
                    <div class="flex items-center justify-between mb-2 px-1">
                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                            {{ $status->label() }}
                        </span>
                        <span class="text-xs text-gray-400">{{ $columnOrders->count() }}</span>
                    </div>

                    <div class="space-y-2 min-h-[120px] rounded-lg p-1 transition"
                         data-column="{{ $status->value }}">
                        @forelse ($columnOrders as $order)
                            @include('orders.partials.card', ['order' => $order, 'statuses' => $statuses])
                        @empty
                            <div class="text-xs text-gray-400 px-1 py-6 text-center border border-dashed border-gray-200 rounded-lg">
                                Nothing here
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Drag and drop. The select on each card does the same job without
         JavaScript, so this is an enhancement rather than a requirement. --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tokenTag = document.querySelector('meta[name="csrf-token"]');
            if (!tokenTag) return;
            const token = tokenTag.content;

            document.querySelectorAll('[data-order-card]').forEach(function (card) {
                card.addEventListener('dragstart', function (e) {
                    e.dataTransfer.setData('text/plain', card.dataset.orderId);
                    e.dataTransfer.effectAllowed = 'move';
                    card.classList.add('opacity-40');
                });
                card.addEventListener('dragend', function () {
                    card.classList.remove('opacity-40');
                });
            });

            document.querySelectorAll('[data-column]').forEach(function (column) {
                column.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    column.classList.add('bg-gray-200');
                });
                column.addEventListener('dragleave', function () {
                    column.classList.remove('bg-gray-200');
                });
                column.addEventListener('drop', function (e) {
                    e.preventDefault();
                    column.classList.remove('bg-gray-200');

                    const orderId = e.dataTransfer.getData('text/plain');
                    if (!orderId) return;

                    fetch('/orders/' + orderId + '/status', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': token,
                        },
                        body: JSON.stringify({ status: column.dataset.column }),
                    }).then(function (response) {
                        return response.json().then(function (data) {
                            if (response.ok) {
                                window.location.reload();
                            } else {
                                window.alert(data.error || 'That order could not be moved.');
                            }
                        });
                    }).catch(function () {
                        window.alert('That order could not be moved.');
                    });
                });
            });
        });
    </script>
</x-app-layout>
