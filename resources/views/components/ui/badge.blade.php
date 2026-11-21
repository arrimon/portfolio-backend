@props(['variant' => 'muted', 'dot' => false])
@php
    $variants = [
        'success' => 'badge-success',
        'warning' => 'badge-warning',
        'muted' => 'badge-muted',
        'info' => 'badge-info',
        'danger' => 'badge-danger',
    ];
    $dots = [
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'muted' => 'bg-slate-400',
        'info' => 'bg-indigo-500',
        'danger' => 'bg-red-500',
    ];
@endphp
<span {{ $attributes->class(['badge', $variants[$variant] ?? $variants['muted']]) }}>
    @if ($dot)
        <span class="status-dot {{ $dots[$variant] ?? $dots['muted'] }}" aria-hidden="true"></span>
    @endif
    {{ $slot }}
</span>
