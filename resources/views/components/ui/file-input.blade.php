@props(['name', 'accept' => null, 'id' => null])
@php
    $id = $id ?? $name;
@endphp
<input id="{{ $id }}" type="file" name="{{ $name }}" @if ($accept) accept="{{ $accept }}" @endif
    {{ $attributes->class(['file-input']) }}>
