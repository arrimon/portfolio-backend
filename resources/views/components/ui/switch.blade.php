@props(['name', 'checked' => false, 'label' => null, 'id' => null, 'value' => '1'])
@php
    $id = $id ?? $name;
@endphp
<input type="hidden" name="{{ $name }}" value="0">
<label for="{{ $id }}" class="inline-flex cursor-pointer items-center gap-3">
    <span class="relative inline-flex h-6 w-11 shrink-0 items-center">
        <input id="{{ $id }}" type="checkbox" name="{{ $name }}" value="{{ $value }}" role="switch"
            @checked($checked) {{ $attributes->class(['peer sr-only']) }}>
        <span class="switch-track peer-checked:bg-indigo-600 peer-focus-visible:ring-3 peer-focus-visible:ring-indigo-500/30 peer-focus-visible:ring-offset-2" aria-hidden="true"></span>
        <span class="switch-knob peer-checked:translate-x-5" aria-hidden="true"></span>
    </span>
    @if ($label)
        <span class="text-sm text-slate-700">{{ $label }}</span>
    @endif
</label>
