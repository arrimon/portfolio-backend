@props(['title' => null, 'description' => null, 'padded' => true, 'bodyClass' => 'card-body'])
<div {{ $attributes->class(['card']) }}>
    @if (isset($header) || $title)
        <div class="card-header">
            @if ($title)
                <div class="min-w-0">
                    <h2 class="text-sm font-semibold text-slate-900">{{ $title }}</h2>
                    @if ($description)
                        <p class="mt-0.5 text-sm text-slate-500">{{ $description }}</p>
                    @endif
                </div>
            @endif
            @isset($header)
                {{ $header }}
            @endisset
        </div>
    @endif

    @if ($padded)
        <div class="{{ $bodyClass }}">{{ $slot }}</div>
    @else
        {{ $slot }}
    @endif

    @isset($footer)
        <div class="card-footer">{{ $footer }}</div>
    @endisset
</div>
