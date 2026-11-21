@props(['variant' => 'primary', 'size' => null, 'href' => null, 'type' => 'button'])
@php
    $variants = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'danger' => 'btn-danger',
        'ghost' => 'btn-ghost',
    ];
    $sizes = [
        'sm' => 'btn-sm',
        'lg' => 'btn-lg',
        'icon' => 'btn-icon',
    ];
    $classes = trim('btn ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? ''));
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->class([$classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class([$classes]) }}>{{ $slot }}</button>
@endif
