@php $input = 'mt-1 w-full rounded border-gray-300 text-sm'; @endphp

<x-admin.translation-tabs
    :locales="$locales"
    :model="$profile"
    :fields="[
        ['name' => 'name', 'label' => 'Full name'],
        ['name' => 'headline', 'label' => 'Headline'],
        ['name' => 'bio', 'label' => 'Bio (plain text)', 'type' => 'textarea'],
    ]" />

<div class="grid gap-4 rounded-lg border border-gray-200 bg-white p-4 md:grid-cols-2">
    <div>
        <label class="block text-sm font-medium">Email</label>
        <input type="email" name="email" value="{{ old('email', $profile->email) }}" class="{{ $input }}">
        @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}" class="{{ $input }}">
        @error('phone')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Location</label>
        <input type="text" name="location" value="{{ old('location', $profile->location) }}" class="{{ $input }}">
        @error('location')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <label class="flex items-center gap-2 pt-6 text-sm">
        <input type="hidden" name="is_available_for_work" value="0">
        <input type="checkbox" name="is_available_for_work" value="1" @checked(old('is_available_for_work', $profile->is_available_for_work))>
        Available for work
    </label>
</div>

<div class="grid gap-4 rounded-lg border border-gray-200 bg-white p-4 md:grid-cols-2">
    <div>
        <label class="block text-sm font-medium">Avatar (JPG / PNG / WebP, max 2 MB)</label>
        @if ($profile->avatar)
            <img src="{{ $profile->avatar->url }}" alt="Current avatar" class="my-2 h-24 w-24 rounded object-cover">
        @endif
        <input type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp" class="mt-1 block w-full text-sm">
        @error('avatar')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        @error('file')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium">CV (PDF, max 5 MB)</label>
        @if ($profile->cv)
            <a href="{{ $profile->cv->url }}" target="_blank" rel="noopener" class="my-2 block text-sm text-indigo-600 underline">{{ $profile->cv->original_name }}</a>
        @endif
        <input type="file" name="cv" accept=".pdf" class="mt-1 block w-full text-sm">
        @error('cv')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>
</div>
