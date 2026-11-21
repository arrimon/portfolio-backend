@props(['title' => 'Nothing here yet', 'message' => null])
<div {{ $attributes->class(['rounded-lg border border-dashed border-slate-300 bg-slate-50/50 px-6 py-10 text-center']) }}>
    <span class="mx-auto mb-3 flex size-10 items-center justify-center rounded-full bg-slate-100 text-slate-400">
        <x-ui.icon name="layers" class="size-5" />
    </span>
    <p class="text-sm font-medium text-slate-700">{{ $title }}</p>
    @if ($message)
        <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">{{ $message }}</p>
    @endif
    @if (! $slot->isEmpty())
        <div class="mt-4 flex justify-center">
            {{ $slot }}
        </div>
    @endif
</div>
