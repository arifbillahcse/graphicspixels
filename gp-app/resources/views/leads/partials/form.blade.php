{{-- Shared by create and edit. $lead is null when creating. --}}
<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label for="name" class="block text-xs font-medium text-gray-500 mb-1">Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" required value="{{ old('name', $lead?->name) }}"
               class="w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label for="email" class="block text-xs font-medium text-gray-500 mb-1">Email <span class="text-red-500">*</span></label>
        <input type="email" name="email" id="email" required value="{{ old('email', $lead?->email) }}"
               class="w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label for="phone" class="block text-xs font-medium text-gray-500 mb-1">Phone</label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $lead?->phone) }}"
               class="w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label for="service" class="block text-xs font-medium text-gray-500 mb-1">Service</label>
        <input type="text" name="service" id="service" value="{{ old('service', $lead?->service) }}"
               placeholder="e.g. Clipping Path"
               class="w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label for="website" class="block text-xs font-medium text-gray-500 mb-1">Website</label>
        <input type="text" name="website" id="website" value="{{ old('website', $lead?->website) }}"
               class="w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label for="company" class="block text-xs font-medium text-gray-500 mb-1">Company</label>
        <input type="text" name="company" id="company" value="{{ old('company', $lead?->company) }}"
               class="w-full rounded-md border-gray-300 text-sm">
    </div>

    <div>
        <label for="status" class="block text-xs font-medium text-gray-500 mb-1">Status</label>
        <select name="status" id="status" class="w-full rounded-md border-gray-300 text-sm">
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}" @selected(old('status', $lead?->status?->value) === $status->value)>
                    {{ $status->label() }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="source" class="block text-xs font-medium text-gray-500 mb-1">Source</label>
        <select name="source" id="source" class="w-full rounded-md border-gray-300 text-sm">
            @foreach ($sources as $source)
                <option value="{{ $source->value }}" @selected(old('source', $lead?->source?->value ?? 'manual') === $source->value)>
                    {{ $source->label() }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <label for="assigned_to" class="block text-xs font-medium text-gray-500 mb-1">Owner</label>
        <select name="assigned_to" id="assigned_to" class="w-full rounded-md border-gray-300 text-sm">
            <option value="">Unassigned</option>
            @foreach ($assignees as $user)
                <option value="{{ $user->id }}" @selected((int) old('assigned_to', $lead?->assigned_to) === $user->id)>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="sm:col-span-2">
        <label for="file_link" class="block text-xs font-medium text-gray-500 mb-1">Cloud link</label>
        <input type="text" name="file_link" id="file_link" value="{{ old('file_link', $lead?->file_link) }}"
               placeholder="Drive or Dropbox URL supplied by the client"
               class="w-full rounded-md border-gray-300 text-sm">
    </div>

    <div class="sm:col-span-2">
        <label for="message" class="block text-xs font-medium text-gray-500 mb-1">Message</label>
        <textarea name="message" id="message" rows="4"
                  class="w-full rounded-md border-gray-300 text-sm">{{ old('message', $lead?->message) }}</textarea>
    </div>
</div>
