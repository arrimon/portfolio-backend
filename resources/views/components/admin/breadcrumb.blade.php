@props(['items' => []])
{{-- $items = [['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Profile']] --}}
@if (count($items))
    <nav aria-label="Breadcrumb" class="mb-2 text-sm text-slate-500">
        <ol class="flex flex-wrap items-center gap-1">
            @foreach ($items as $item)
                <li class="flex items-center gap-1">
                    @if (! $loop->first) <span aria-hidden="true">/</span> @endif
                    @if (! empty($item['url']) && ! $loop->last)
                        <a href="{{ $item['url'] }}" class="hover:underline">{{ $item['label'] }}</a>
                    @else
                        <span aria-current="page">{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </nav>
@endif
