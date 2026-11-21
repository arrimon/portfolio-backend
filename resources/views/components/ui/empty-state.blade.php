@props(['title' => 'কিছু পাওয়া যায়নি', 'message' => null])
<div class="rounded-lg border border-dashed border-slate-300 bg-white p-10 text-center">
    <p class="font-medium text-slate-700">{{ $title }}</p>
    @if ($message)
        <p class="mt-1 text-sm text-slate-500">{{ $message }}</p>
    @endif
    {{ $slot }}
</div>
