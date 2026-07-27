<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('leads.show', $lead) }}" class="text-xs text-gray-500 hover:text-gray-900">&larr; Back to lead</a>
            <h1 class="text-lg font-semibold text-gray-900">Convert {{ $lead->name }} to an order</h1>
        </div>
    </x-slot>

    @include('partials.flash')

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('leads.convert.store', $lead) }}"
                  class="bg-white rounded-lg border border-gray-200 p-6">
                @csrf

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label for="service_type" class="block text-xs font-medium text-gray-500 mb-1">
                            Service <span class="text-red-500">*</span>
                        </label>
                        <select name="service_type" id="service_type" required class="w-full rounded-md border-gray-300 text-sm">
                            @foreach ($serviceTypes as $service)
                                <option value="{{ $service->value }}"
                                    @selected(old('service_type', $guessedService?->value) === $service->value)>
                                    {{ $service->label() }}
                                </option>
                            @endforeach
                        </select>
                        @if ($guessedService && $lead->service)
                            <p class="mt-1 text-xs text-gray-500">
                                Pre-selected from the enquiry: &ldquo;{{ $lead->service }}&rdquo;
                            </p>
                        @endif
                    </div>

                    <div>
                        <label for="image_count" class="block text-xs font-medium text-gray-500 mb-1">
                            Images <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="image_count" id="image_count" min="1" required
                               value="{{ old('image_count', 100) }}"
                               class="w-full rounded-md border-gray-300 text-sm">
                    </div>

                    <div>
                        <label for="deadline" class="block text-xs font-medium text-gray-500 mb-1">
                            Deadline <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" name="deadline" id="deadline" required
                               value="{{ old('deadline', $defaultDeadline->format('Y-m-d\TH:i')) }}"
                               class="w-full rounded-md border-gray-300 text-sm">
                        <p class="mt-1 text-xs text-gray-500">Defaults to the standard 24-hour turnaround.</p>
                    </div>

                    <div>
                        <label for="rate_tier" class="block text-xs font-medium text-gray-500 mb-1">Rate tier</label>
                        <select name="rate_tier" id="rate_tier" class="w-full rounded-md border-gray-300 text-sm">
                            @foreach ($rateTiers as $tier)
                                <option value="{{ $tier->value }}"
                                    @selected(old('rate_tier', $existingClient?->rate_tier->value ?? 'standard') === $tier->value)>
                                    {{ $tier->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="team_leader_id" class="block text-xs font-medium text-gray-500 mb-1">Team leader</label>
                        <select name="team_leader_id" id="team_leader_id" class="w-full rounded-md border-gray-300 text-sm">
                            <option value="">Assign later</option>
                            @foreach ($teamLeaders as $leader)
                                <option value="{{ $leader->id }}" @selected((int) old('team_leader_id') === $leader->id)>
                                    {{ $leader->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end pb-2">
                        <label class="flex items-center gap-2 text-sm text-gray-700">
                            <input type="checkbox" name="rush" value="1" @checked(old('rush')) class="rounded border-gray-300">
                            Rush job
                        </label>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="file_intake_link" class="block text-xs font-medium text-gray-500 mb-1">File intake link</label>
                        <input type="text" name="file_intake_link" id="file_intake_link"
                               value="{{ old('file_intake_link', $lead->file_link) }}"
                               placeholder="Drive or Dropbox folder holding the source images"
                               class="w-full rounded-md border-gray-300 text-sm">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="notes" class="block text-xs font-medium text-gray-500 mb-1">Brief</label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="w-full rounded-md border-gray-300 text-sm">{{ old('notes', $lead->message) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex items-center gap-3">
                    <button type="submit" class="px-4 py-2 rounded-md bg-[#01015E] text-white text-sm hover:bg-[#01015E]/90">
                        Create order
                    </button>
                    <a href="{{ route('leads.show', $lead) }}" class="text-sm text-gray-500 hover:text-gray-900">Cancel</a>
                </div>
            </form>
        </div>

        {{-- What will happen --}}
        <div class="space-y-6">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-3">The enquiry</h2>
                <dl class="space-y-2 text-sm">
                    <div>
                        <dt class="text-xs text-gray-500">Name</dt>
                        <dd class="text-gray-900">{{ $lead->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500">Email</dt>
                        <dd class="text-gray-900 break-all">{{ $lead->email }}</dd>
                    </div>
                    @if ($lead->company)
                        <div>
                            <dt class="text-xs text-gray-500">Company</dt>
                            <dd class="text-gray-900">{{ $lead->company }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs text-gray-500">Source</dt>
                        <dd class="text-gray-900">{{ $lead->source->label() }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-sm font-semibold text-gray-900 mb-3">On submit</h2>
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex gap-2">
                        <span class="text-[#C3009D]">&bull;</span>
                        @if ($existingClient)
                            <span>Attaches to the existing client <strong>{{ $existingClient->displayName() }}</strong>.</span>
                        @else
                            <span>Creates a new client record for this email.</span>
                        @endif
                    </li>
                    <li class="flex gap-2">
                        <span class="text-[#C3009D]">&bull;</span>
                        <span>Creates the order and puts it on the production board.</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-[#C3009D]">&bull;</span>
                        <span>Marks the lead as <strong>Converted</strong>.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
