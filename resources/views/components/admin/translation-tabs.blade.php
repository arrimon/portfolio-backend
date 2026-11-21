@props(['locales', 'model' => null, 'fields'])
@php
    $uid = 'tt' . \Illuminate\Support\Str::random(6);
    if ($model) { $model->loadMissing('translations'); }
@endphp
<div id="{{ $uid }}" class="rounded-lg border border-gray-200 bg-white">
    <div class="flex border-b border-gray-200">
        @foreach ($locales as $i => $loc)
            <button type="button" data-tab="{{ $loc->code }}"
                class="px-4 py-2 text-sm {{ $i === 0 ? 'border-b-2 border-indigo-600 font-semibold text-indigo-700' : 'text-gray-600' }}">
                {{ $loc->native_name }}
                @if ($model && ! $model->hasTranslation($loc->code))
                    <x-admin.translation-badge />
                @endif
                @if ($errors->has("translations.{$loc->code}.*"))
                    <span class="ml-1 font-bold text-red-600">!</span>
                @endif
            </button>
        @endforeach
    </div>

    @foreach ($locales as $i => $loc)
        <div data-panel="{{ $loc->code }}" class="space-y-4 p-4 {{ $i === 0 ? '' : 'hidden' }}">
            @foreach ($fields as $f)
                @php
                    $key = "translations.{$loc->code}.{$f['name']}";
                    $val = old($key, $model?->translations->firstWhere('locale', $loc->code)?->{$f['name']});
                    $input = 'mt-1 w-full rounded border-gray-300 text-sm';
                @endphp
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ $f['label'] }}</label>
                    @if (($f['type'] ?? 'text') === 'textarea')
                        <textarea rows="5" name="translations[{{ $loc->code }}][{{ $f['name'] }}]" class="{{ $input }}">{{ $val }}</textarea>
                    @else
                        <input type="text" name="translations[{{ $loc->code }}][{{ $f['name'] }}]" value="{{ $val }}" class="{{ $input }}">
                    @endif
                    @error($key)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            @endforeach
        </div>
    @endforeach
</div>
<script>
(function () {
    const root = document.getElementById('{{ $uid }}');
    const tabs = root.querySelectorAll('[data-tab]');
    tabs.forEach(function (btn) {
        btn.addEventListener('click', function () {
            tabs.forEach(function (b) {
                const on = b === btn;
                b.classList.toggle('border-b-2', on);
                b.classList.toggle('border-indigo-600', on);
                b.classList.toggle('font-semibold', on);
            });
            root.querySelectorAll('[data-panel]').forEach(function (p) {
                p.classList.toggle('hidden', p.dataset.panel !== btn.dataset.tab);
            });
        });
    });
})();
</script>
