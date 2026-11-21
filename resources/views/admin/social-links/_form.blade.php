@php $input = 'mt-1 w-full rounded border-gray-300 text-sm'; @endphp

<div>
    <label class="block text-sm font-medium">Platform</label>
    <select name="platform" class="{{ $input }}">
        @foreach (config('portfolio.social_platforms') as $value => $label)
            <option value="{{ $value }}" @selected(old('platform', $link->platform) === $value)>{{ $label }}</option>
        @endforeach
    </select>
    @error('platform')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<div>
    <label class="block text-sm font-medium">URL (https:// or mailto:)</label>
    <input type="text" name="url" value="{{ old('url', $link->url) }}" class="{{ $input }}" placeholder="https://github.com/username">
    @error('url')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>

<label class="flex items-center gap-2 text-sm">
    <input type="hidden" name="is_active" value="0">
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $link->is_active))>
    Active (shown on public site)
</label>

<div class="flex gap-3">
    <button class="rounded bg-indigo-600 px-5 py-2 text-sm font-medium text-white hover:bg-indigo-700">Save</button>
    <a href="{{ route('admin.social-links.index') }}" class="px-3 py-2 text-sm text-gray-600">Cancel</a>
</div>
