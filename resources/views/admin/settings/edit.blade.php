<x-layouts.admin
    title="Settings"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Settings'],
    ]"
>
    <form method="POST" action="{{ route('admin.settings.update') }}" id="settings-form" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="flex gap-2 border-b border-gray-200" id="settings-tabs">
            @foreach (['general' => 'General', 'seo' => 'SEO', 'theme' => 'Theme'] as $group => $label)
                <button type="button" data-group="{{ $group }}"
                    class="px-4 py-2 text-sm {{ $loop->first ? 'border-b-2 border-indigo-600 font-semibold text-indigo-700' : 'text-gray-600' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        @foreach (['general', 'seo', 'theme'] as $group)
            <div data-group-panel="{{ $group }}" class="rounded-lg border border-gray-200 bg-white p-4 {{ $loop->first ? '' : 'hidden' }}">
                @include('admin.settings._' . $group)
            </div>
        @endforeach

        <button class="rounded bg-indigo-600 px-5 py-2 text-sm font-medium text-white hover:bg-indigo-700">Save settings</button>
    </form>

    <script>
    (function () {
        const tabs = document.querySelectorAll('#settings-tabs [data-group]');
        tabs.forEach(function (btn) {
            btn.addEventListener('click', function () {
                tabs.forEach(function (b) {
                    const on = b === btn;
                    b.classList.toggle('border-b-2', on);
                    b.classList.toggle('border-indigo-600', on);
                    b.classList.toggle('font-semibold', on);
                });
                document.querySelectorAll('[data-group-panel]').forEach(function (p) {
                    p.classList.toggle('hidden', p.dataset.groupPanel !== btn.dataset.group);
                });
            });
        });
    })();
    </script>
</x-layouts.admin>
