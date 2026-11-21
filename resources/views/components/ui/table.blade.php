@props(['head' => null])
<div class="overflow-x-auto">
    <table class="data-table">
        <thead>
            {{ $head }}
        </thead>
        <tbody class="divide-y divide-slate-200">
            {{ $slot }}
        </tbody>
    </table>
</div>
