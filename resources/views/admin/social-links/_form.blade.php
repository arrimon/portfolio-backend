@php
    $urlPrefix = str_starts_with((string) old('url', $link->url), 'mailto:') ? 'mailto:' : 'https://';
@endphp

<x-ui.card title="Link details" description="Choose a platform and paste the full profile URL.">
    <div class="space-y-5">
        <x-ui.form-field name="platform" label="Platform" for="platform">
            <select id="platform" name="platform" class="select">
                @foreach (config('portfolio.social_platforms') as $value => $label)
                    <option value="{{ $value }}" @selected(old('platform', $link->platform) === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </x-ui.form-field>

        <x-ui.form-field name="url" label="URL" for="url" help="Only https:// links or mailto: addresses are allowed.">
            <div class="flex">
                <span class="inline-flex items-center rounded-l-lg border border-r-0 border-slate-300 bg-slate-50 px-3 font-mono text-xs text-slate-500">{{ $urlPrefix }}</span>
                <input id="url" type="text" name="url" value="{{ old('url', $link->url) }}"
                    class="input rounded-l-none" placeholder="github.com/username" autocomplete="url">
            </div>
        </x-ui.form-field>

        <div class="border-t border-slate-200 pt-4">
            <x-ui.switch name="is_active" :checked="old('is_active', $link->is_active)" label="Active (shown on public site)" />
            <p class="mt-1.5 text-xs text-slate-500">Inactive links stay saved but are hidden from the public site.</p>
        </div>
    </div>

    <x-slot:footer>
        <x-ui.button :href="route('admin.social-links.index')" variant="ghost">Cancel</x-ui.button>
        <x-ui.button type="submit">Save link</x-ui.button>
    </x-slot:footer>
</x-ui.card>
