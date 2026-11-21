@props(['paginator'])
@if ($paginator->hasPages())
    <div class="mt-6 flex justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 shadow-xs">
        {{ $paginator->links() }}
    </div>
@endif
