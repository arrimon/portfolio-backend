@php
    $messages = array_filter([
        'success' => session('success') ?? session('status'),
        'error' => session('error'),
    ]);
    $styles = [
        'success' => 'border-green-200 bg-green-50 text-green-800',
        'error' => 'border-red-200 bg-red-50 text-red-800',
    ];
@endphp

@foreach ($messages as $type => $message)
    <div role="alert" class="mb-4 rounded-md border px-4 py-3 text-sm {{ $styles[$type] }}">
        {{ $message }}
    </div>
@endforeach
