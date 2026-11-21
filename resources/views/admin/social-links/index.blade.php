<x-layouts.admin
    title="Social links"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Social links'],
    ]"
>
    <div class="mb-6 flex items-center justify-end">
        <a href="{{ route('admin.social-links.create') }}" class="rounded bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">Add link</a>
    </div>

    @php $ids = $links->pluck('id')->all(); $platforms = config('portfolio.social_platforms'); @endphp

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-4 py-2">Order</th>
                    <th class="px-4 py-2">Platform</th>
                    <th class="px-4 py-2">URL</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($links as $i => $link)
                    <tr>
                        <td class="px-4 py-2">
                            @foreach (['up' => [-1, '↑'], 'down' => [1, '↓']] as $dir => [$delta, $icon])
                                @if (isset($ids[$i + $delta]))
                                    @php $new = $ids; [$new[$i], $new[$i + $delta]] = [$new[$i + $delta], $new[$i]]; @endphp
                                    <form method="POST" action="{{ route('admin.social-links.reorder') }}" class="inline">
                                        @csrf
                                        @foreach ($new as $id)
                                            <input type="hidden" name="order[]" value="{{ $id }}">
                                        @endforeach
                                        <button class="rounded border px-2 py-0.5 hover:bg-gray-100" aria-label="Move {{ $dir }}">{{ $icon }}</button>
                                    </form>
                                @endif
                            @endforeach
                        </td>
                        <td class="px-4 py-2 font-medium">{{ $platforms[$link->platform] ?? $link->platform }}</td>
                        <td class="max-w-xs truncate px-4 py-2 text-gray-600">{{ $link->url }}</td>
                        <td class="px-4 py-2">
                            <span class="rounded px-2 py-0.5 text-xs {{ $link->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                                {{ $link->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('admin.social-links.edit', $link) }}" class="text-indigo-600 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.social-links.destroy', $link) }}" class="ml-3 inline"
                                  onsubmit="return confirm('Delete this link?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">No social links yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
