<x-admin.translation-tabs
    :locales="$locales"
    :model="$section"
    title="Content"
    :fields="[
        ['name' => 'title', 'label' => 'Title'],
        ['name' => 'subtitle', 'label' => 'Subtitle'],
    ]" />

<x-ui.card title="Layout" description="Choose how this section is rendered on the public site.">
    <x-ui.form-field name="variant" label="Layout variant" for="variant" help="Only predefined layouts are allowed.">
        <select id="variant" name="variant" class="select md:w-64">
            @foreach ($section->key->variants() as $variant)
                <option value="{{ $variant }}" @selected(old('variant', $section->variant ?? 'default') === $variant)>{{ $variant }}</option>
            @endforeach
        </select>
    </x-ui.form-field>
</x-ui.card>
