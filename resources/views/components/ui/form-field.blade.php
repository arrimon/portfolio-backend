@props(['name' => null, 'label' => null, 'for' => null, 'help' => null, 'error' => null])
@php
    $id = $for ?? $name;
    $message = $error ?? ($name ? $errors->first($name) : null);
@endphp
<div {{ $attributes }}>
    @if ($label)
        <label @if ($id) for="{{ $id }}" @endif class="label">{{ $label }}</label>
    @endif

    {{ $slot }}

    @if ($help)
        <p class="help">{{ $help }}</p>
    @endif

    @if ($message)
        <p class="field-error" role="alert">
            <x-ui.icon name="alert-circle" class="mt-px size-3.5 shrink-0" />
            <span>{{ $message }}</span>
        </p>
    @endif
</div>
