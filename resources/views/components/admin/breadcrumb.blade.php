@props(['items' => []])
{{-- $items = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Profile']] --}}
@if (count($items))
    <nav aria-label="Breadcrumb" {{ $attributes->class(['text-sm text-slate-500']) }}>
        <ol class="flex flex-wrap items-center gap-1.5">
            @foreach ($items as $item)
                <li class="flex items-center gap-1.5">
                    @if (! $loop->first)
                        <x-ui.icon name="chevron-right" class="size-3.5 text-slate-400" />
                    @endif
                    @if (! empty($item['url']) && ! $loop->last)
                        <a href="{{ $item['url'] }}" class="rounded-sm transition-colors hover:text-slate-900 focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-indigo-500/30">{{ $item['label'] }}</a>
                    @else
                        <span @class(['font-medium text-slate-700' => $loop->last]) @if ($loop->last) aria-current="page" @endif>{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
