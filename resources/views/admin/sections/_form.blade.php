<x-admin.translation-tabs
    :locales="$locales"
    :model="$section"
    :fields="[
        ['name' => 'title', 'label' => 'Title'],
        ['name' => 'subtitle', 'label' => 'Subtitle'],
    ]" />

<div class="rounded-lg border border-gray-200 bg-white p-4">
    <label class="block text-sm font-medium">Layout variant</label>
    <select name="variant" class="mt-1 w-full rounded border-gray-300 text-sm md:w-64">
        @foreach ($section->key->variants() as $variant)
            <option value="{{ $variant }}" @selected(old('variant', $section->variant ?? 'default') === $variant)>{{ $variant }}</option>
        @endforeach
    </select>
    @error('variant')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
</div>
