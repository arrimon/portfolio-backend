@php
    $alerts = [];

    if ($success = session('success') ?? session('status')) {
        $alerts[] = ['type' => 'success', 'title' => 'Success', 'message' => $success, 'errors' => []];
    }

    if ($error = session('error')) {
        $alerts[] = ['type' => 'error', 'title' => 'Something went wrong', 'message' => $error, 'errors' => []];
    }

    if ($errors->any() && ! session('error')) {
        $alerts[] = [
            'type' => 'error',
            'title' => 'Please fix the following',
            'message' => null,
            'errors' => $errors->all(),
        ];
    }

    $styles = [
        'success' => [
            'wrapper' => 'border-emerald-200 border-l-emerald-500 bg-emerald-50 text-emerald-800',
            'icon' => 'text-emerald-500',
            'iconName' => 'check-circle',
        ],
        'error' => [
            'wrapper' => 'border-red-200 border-l-red-500 bg-red-50 text-red-800',
            'icon' => 'text-red-500',
            'iconName' => 'alert-circle',
        ],
    ];
@endphp

@foreach ($alerts as $alert)
    @php $style = $styles[$alert['type']]; @endphp
    <div data-alert @if ($alert['type'] === 'success') data-alert-autohide @endif
        role="{{ $alert['type'] === 'error' ? 'alert' : 'status' }}"
        aria-live="{{ $alert['type'] === 'error' ? 'assertive' : 'polite' }}"
        class="mb-5 flex items-start gap-3 rounded-xl border border-l-4 px-4 py-3 text-sm shadow-xs transition-opacity duration-200 {{ $style['wrapper'] }}">
        <x-ui.icon :name="$style['iconName']" class="mt-0.5 size-5 shrink-0 {{ $style['icon'] }}" />
        <div class="min-w-0 flex-1">
            <p class="font-medium">{{ $alert['title'] }}</p>
            @if ($alert['message'])
                <p class="mt-0.5 opacity-90">{{ $alert['message'] }}</p>
            @endif
            @if (count($alert['errors']))
                <ul class="mt-1 list-inside list-disc space-y-0.5 opacity-90">
                    @foreach ($alert['errors'] as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <button type="button" data-dismiss aria-label="Dismiss notification"
            class="-m-1 shrink-0 rounded-lg p-1 opacity-70 transition hover:bg-black/5 hover:opacity-100 focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-slate-400/40">
            <x-ui.icon name="x" class="size-4" />
        </button>
    </div>
@endforeach
