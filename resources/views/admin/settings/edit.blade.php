<x-layouts.admin
    title="Settings"
    subtitle="Configure site-wide content, SEO defaults and theme preferences."
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Settings'],
    ]"
>
    <form method="POST" action="{{ route('admin.settings.update') }}" id="settings-form" data-tabs class="space-y-6">
        @csrf
        @method('PUT')

        <div role="tablist" aria-label="Settings groups"
            class="flex gap-1 overflow-x-auto border-b border-slate-200 px-1">
            @foreach (['general' => 'General', 'seo' => 'SEO', 'theme' => 'Theme'] as $group => $label)
                <button type="button" id="settings-tab-{{ $group }}" role="tab" data-tab="{{ $group }}"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                    aria-controls="settings-panel-{{ $group }}"
                    tabindex="{{ $loop->first ? '0' : '-1' }}"
                    class="relative -mb-px flex h-11 shrink-0 items-center border-b-2 border-transparent px-3 text-sm font-medium text-slate-500 transition-colors duration-150 hover:text-slate-800 focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-indigo-500/30 aria-selected:border-indigo-600 aria-selected:text-indigo-700">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        @foreach (['general', 'seo', 'theme'] as $group)
            <div id="settings-panel-{{ $group }}" role="tabpanel" aria-labelledby="settings-tab-{{ $group }}"
                data-tab-panel="{{ $group }}" @if (! $loop->first) hidden @endif>
                @include('admin.settings._' . $group)
            </div>
        @endforeach

        <div class="sticky bottom-0 z-20 -mx-4 border-t border-slate-200 bg-white/90 px-4 py-3 backdrop-blur sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="mx-auto flex max-w-7xl items-center justify-end gap-3">
                <p class="mr-auto hidden text-xs text-slate-500 sm:block">Changes are applied to the public portfolio immediately.</p>
                <x-ui.button type="submit">Save settings</x-ui.button>
            </div>
        </div>
    </form>
</x-layouts.admin>
