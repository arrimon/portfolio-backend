@props(['name', 'label', 'type' => 'text', 'value' => null])
<div class="mb-4">
    <label for="{{ $name }}" class="label">{{ $label }}</label>
    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
           @if ($type !== 'password') value="{{ old($name, $value) }}" @endif
           {{ $attributes->class([
               'input',
               'border-red-400 focus-visible:border-red-500 focus-visible:ring-red-500/20' => $errors->has($name),
           ]) }}>
    @error($name)
        <p class="field-error" role="alert">
            <x-ui.icon name="alert-circle" class="mt-px size-3.5 shrink-0" />
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
