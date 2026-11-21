{{-- Renders all settings of $group from config/portfolio.php --}}
@php $input = 'w-full rounded border-gray-300 text-sm'; @endphp
<div class="space-y-5">
    @foreach (config("portfolio.settings.{$group}") as $key => $def)
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ $def['label'] }}</label>

            @if ($def['translatable'])
                <div class="mt-1 space-y-2">
                    @foreach ($locales as $loc)
                        @php
                            $name = "translated.{$key}.{$loc->code}";
                            $val = old($name, $settings->get($key)?->translations->firstWhere('locale', $loc->code)?->value);
                        @endphp
                        <div class="flex items-start gap-2">
                            <span class="w-10 pt-2 text-xs uppercase text-gray-500">{{ $loc->code }}</span>
                            <div class="flex-1">
                                @if (($def['input'] ?? 'text') === 'textarea')
                                    <textarea rows="3" name="translated[{{ $key }}][{{ $loc->code }}]" class="{{ $input }}">{{ $val }}</textarea>
                                @else
                                    <input type="text" name="translated[{{ $key }}][{{ $loc->code }}]" value="{{ $val }}" class="{{ $input }}">
                                @endif
                                @error($name)<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @php $val = old("plain.{$key}", $settings->get($key)?->value ?? ($def['default'] ?? '')); @endphp
                @if (isset($def['in']))
                    <select name="plain[{{ $key }}]" class="mt-1 {{ $input }} md:w-64">
                        @foreach ($def['in'] as $option)
                            <option value="{{ $option }}" @selected($val === $option)>{{ $option }}</option>
                        @endforeach
                    </select>
                @else
                    <input type="text" name="plain[{{ $key }}]" value="{{ $val }}" class="mt-1 {{ $input }}">
                @endif
                @error("plain.{$key}")<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            @endif
        </div>
    @endforeach
</div>
