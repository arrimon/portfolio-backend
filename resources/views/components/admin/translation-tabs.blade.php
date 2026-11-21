@props(['locales', 'model' => null, 'fields', 'title' => null])
@php
    $uid = 'tt-' . \Illuminate\Support\Str::random(8);

    if ($model) {
        $model->loadMissing('translations');
    }
@endphp

<div class="card" data-tabs>
    @if ($title)
        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 px-5 py-3.5">
            <h2 class="text-sm font-semibold text-slate-900">{{ $title }}</h2>
            <p class="text-xs text-slate-500">Each language is saved independently.</p>
        </div>
    @endif

    <div role="tablist" aria-label="{{ $title ?? 'Translations' }}"
        class="flex w-full divide-x divide-slate-200 border-b border-slate-200 bg-slate-50/70 {{ $title ? '' : 'rounded-t-[inherit]' }}">
        @foreach ($locales as $i => $loc)
            <button type="button" id="{{ $uid }}-tab-{{ $loc->code }}" role="tab" data-tab="{{ $loc->code }}"
                aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                aria-controls="{{ $uid }}-panel-{{ $loc->code }}"
                tabindex="{{ $i === 0 ? '0' : '-1' }}"
                class="relative -mb-px flex h-12 min-w-0 flex-1 items-center justify-center gap-2 border-b-2 border-transparent px-4 text-sm font-medium text-slate-500 transition-colors duration-150 hover:bg-slate-100/80 hover:text-slate-800 focus-visible:z-10 focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-inset focus-visible:ring-indigo-500/30 aria-selected:border-indigo-600 aria-selected:bg-white aria-selected:font-semibold aria-selected:text-indigo-700">
                <span class="truncate">{{ $loc->native_name }}</span>
                <span class="shrink-0 rounded-md bg-slate-100 px-1.5 py-0.5 font-mono text-[10px] font-medium uppercase tracking-wide text-slate-500">{{ strtoupper($loc->code) }}</span>

                @if ($model && ! $model->hasTranslation($loc->code))
                    <span class="shrink-0">
                        <x-admin.translation-badge />
                    </span>
                @endif

                @if ($errors->has("translations.{$loc->code}.*"))
                    <span class="size-1.5 shrink-0 rounded-full bg-red-500" aria-hidden="true"></span>
                    <span class="sr-only">has validation errors</span>
                @endif
            </button>
        @endforeach
    </div>

    @foreach ($locales as $i => $loc)
        <div id="{{ $uid }}-panel-{{ $loc->code }}" role="tabpanel"
            aria-labelledby="{{ $uid }}-tab-{{ $loc->code }}" data-tab-panel="{{ $loc->code }}"
            @if ($i !== 0) hidden @endif class="space-y-5 p-5">
            @foreach ($fields as $f)
                @php
                    $key = "translations.{$loc->code}.{$f['name']}";
                    $fieldId = $uid . '-' . $loc->code . '-' . $f['name'];
                    $val = old($key, $model?->translations->firstWhere('locale', $loc->code)?->{$f['name']});
                @endphp

                <div>
                    <label for="{{ $fieldId }}" class="label">{{ $f['label'] }}</label>

                    @if (($f['type'] ?? 'text') === 'textarea')
                        <textarea id="{{ $fieldId }}" rows="5" name="translations[{{ $loc->code }}][{{ $f['name'] }}]" class="textarea">{{ $val }}</textarea>
                    @else
                        <input id="{{ $fieldId }}" type="text" name="translations[{{ $loc->code }}][{{ $f['name'] }}]" value="{{ $val }}" class="input">
                    @endif

                    @error($key)
                        <p class="field-error" role="alert">
                            <x-ui.icon name="alert-circle" class="mt-px size-3.5 shrink-0" />
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>
            @endforeach
        </div>
    @endforeach
</div>