@php
    $swatches = [
        'indigo' => 'bg-indigo-500',
        'emerald' => 'bg-emerald-500',
        'rose' => 'bg-rose-500',
        'amber' => 'bg-amber-500',
        'sky' => 'bg-sky-500',
    ];
@endphp

<x-ui.card :padded="false">
    @foreach (config("portfolio.settings.{$group}") as $key => $def)
        @php
            $isTranslatable = $def['translatable'];
            $help = match (true) {
                isset($def['max']) => 'Up to ' . $def['max'] . ' characters.',
                isset($def['email']) => 'Public email address.',
                default => null,
            };
        @endphp

        <div class="grid gap-4 border-b border-slate-200 px-5 py-5 last:border-0 lg:grid-cols-3">
            <div class="lg:col-span-1">
                <p class="text-sm font-medium text-slate-700">{{ $def['label'] }}</p>
                @if ($isTranslatable)
                    <p class="help">Translated per language.</p>
                @endif
                @if ($help)
                    <p class="help">{{ $help }}</p>
                @endif
            </div>

            <div class="min-w-0 lg:col-span-2">
                @if ($isTranslatable)
                    <div class="space-y-2">
                        @foreach ($locales as $loc)
                            @php
                                $name = "translated.{$key}.{$loc->code}";
                                $id = "setting-{$key}-{$loc->code}";
                                $val = old($name, $settings->get($key)?->translations->firstWhere('locale', $loc->code)?->value);
                            @endphp

                            <div class="flex items-start gap-2">
                                <label for="{{ $id }}"
                                    class="mt-1.5 inline-flex w-10 shrink-0 items-center justify-center rounded-md bg-slate-100 px-1.5 py-0.5 font-mono text-[10px] font-medium uppercase tracking-wide text-slate-500">{{ strtoupper($loc->code) }}</label>

                                <div class="min-w-0 flex-1">
                                    @if (($def['input'] ?? 'text') === 'textarea')
                                        <textarea id="{{ $id }}" rows="3" name="translated[{{ $key }}][{{ $loc->code }}]" class="textarea">{{ $val }}</textarea>
                                    @else
                                        <input id="{{ $id }}" type="text" name="translated[{{ $key }}][{{ $loc->code }}]" value="{{ $val }}" class="input">
                                    @endif

                                    @error($name)
                                        <p class="field-error" role="alert">
                                            <x-ui.icon name="alert-circle" class="mt-px size-3.5 shrink-0" />
                                            <span>{{ $message }}</span>
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    @php $val = old("plain.{$key}", $settings->get($key)?->value ?? ($def['default'] ?? '')); @endphp

                    @if ($key === 'accent')
                        <div class="flex flex-wrap gap-3" role="radiogroup" aria-label="{{ $def['label'] }}">
                            @foreach ($def['in'] as $option)
                                @php $id = "plain-accent-{$option}"; @endphp
                                <label for="{{ $id }}"
                                    class="flex cursor-pointer items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm capitalize shadow-xs transition-colors has-[:checked]:border-indigo-500 has-[:checked]:ring-2 has-[:checked]:ring-indigo-500 has-[:checked]:ring-offset-2">
                                    <input id="{{ $id }}" type="radio" name="plain[accent]" value="{{ $option }}"
                                        class="sr-only" @checked($val === $option)>
                                    <span class="size-5 rounded-full ring-1 ring-black/10 {{ $swatches[$option] ?? 'bg-slate-400' }}" aria-hidden="true"></span>
                                    <span class="font-medium text-slate-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        </div>
                    @elseif ($key === 'default_mode')
                        <x-ui.segmented name="plain[default_mode]"
                            :options="array_combine($def['in'], array_map('ucfirst', $def['in']))"
                            :selected="$val" ariaLabel="Default mode" />
                    @elseif (isset($def['in']))
                        <select id="setting-{{ $key }}" name="plain[{{ $key }}]" class="select md:w-64">
                            @foreach ($def['in'] as $option)
                                <option value="{{ $option }}" @selected($val === $option)>{{ $option }}</option>
                            @endforeach
                        </select>
                    @else
                        <input id="setting-{{ $key }}" type="text" name="plain[{{ $key }}]" value="{{ $val }}" class="input">
                    @endif

                    @error("plain.{$key}")
                        <p class="field-error" role="alert">
                            <x-ui.icon name="alert-circle" class="mt-px size-3.5 shrink-0" />
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                @endif
            </div>
        </div>
    @endforeach
</x-ui.card>
