@props(['name', 'options' => [], 'selected' => null, 'label' => null, 'ariaLabel' => null])
<div>
    @if ($label)
        <span class="label">{{ $label }}</span>
    @endif
    <div class="segmented" role="radiogroup" @if ($ariaLabel || $label) aria-label="{{ $ariaLabel ?? $label }}" @endif>
        @foreach ($options as $value => $text)
            @php $id = $name . '-' . $value; @endphp
            <label for="{{ $id }}">
                <input id="{{ $id }}" type="radio" name="{{ $name }}" value="{{ $value }}"
                    class="sr-only" @checked((string) $selected === (string) $value)>
                <span>{{ $text }}</span>
            </label>
        @endforeach
    </div>
</div>
