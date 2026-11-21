@props(['on' => false, 'action'])
<form method="POST" action="{{ $action }}" class="inline">
    @csrf
    @method('PATCH')
    <button type="submit" role="switch" aria-checked="{{ $on ? 'true' : 'false' }}"
        class="relative inline-flex h-6 w-11 items-center rounded-full transition {{ $on ? 'bg-indigo-600' : 'bg-gray-300' }}">
        <span class="sr-only">Toggle</span>
        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition {{ $on ? 'translate-x-6' : 'translate-x-1' }}"></span>
    </button>
</form>
