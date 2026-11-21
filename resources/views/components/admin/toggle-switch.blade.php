@props(['on' => false, 'action', 'label' => 'Toggle'])
<form method="POST" action="{{ $action }}" class="inline-flex">
    @csrf
    @method('PATCH')
    <button type="submit" role="switch" aria-checked="{{ $on ? 'true' : 'false' }}"
        class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full transition-colors duration-150 focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-indigo-500/30 focus-visible:ring-offset-2 {{ $on ? 'bg-indigo-600' : 'bg-slate-300' }}">
        <span class="sr-only">{{ $label }}</span>
        <span class="inline-block size-5 rounded-full bg-white shadow-xs transition-transform duration-150 {{ $on ? 'translate-x-[1.375rem]' : 'translate-x-0.5' }}"></span>
    </button>
</form>
