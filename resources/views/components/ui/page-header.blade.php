@props(['title' => null, 'subtitle' => null, 'breadcrumbs' => []])
<div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
    <div class="min-w-0">
        <x-admin.breadcrumb :items="$breadcrumbs" class="mb-2 lg:hidden" />
        <h1 class="page-title truncate">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex shrink-0 flex-wrap items-center gap-2">
            {{ $actions }}
        </div>
    @endisset
</div>
