<x-layouts.admin
    title="Sections"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Sections'],
    ]"
>
    @php $ids = $sections->pluck('id')->all(); @endphp

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-4 py-2">Order</th>
                    <th class="px-4 py-2">Section</th>
                    <th class="px-4 py-2">Title</th>
                    <th class="px-4 py-2">Variant</th>
                    <th class="px-4 py-2">Visible</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($sections as $i => $section)
                    <tr>
                        <td class="px-4 py-2">
                            @foreach (['up' => [-1, '↑'], 'down' => [1, '↓']] as $dir => [$delta, $icon])
                                @if (isset($ids[$i + $delta]))
                                    @php $new = $ids; [$new[$i], $new[$i + $delta]] = [$new[$i + $delta], $new[$i]]; @endphp
                                    <form method="POST" action="{{ route('admin.sections.reorder') }}" class="inline">
                                        @csrf
                                        @foreach ($new as $id)
                                            <input type="hidden" name="order[]" value="{{ $id }}">
                                        @endforeach
                                        <button class="rounded border px-2 py-0.5 hover:bg-gray-100" aria-label="Move {{ $dir }}">{{ $icon }}</button>
                                    </form>
                                @endif
                            @endforeach
                        </td>
                        <td class="px-4 py-2 font-medium">{{ $section->key->label() }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ $section->t('title') ?? '—' }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ $section->variant ?? 'default' }}</td>
                        <td class="px-4 py-2">
                            <x-admin.toggle-switch :on="$section->is_enabled" :action="route('admin.sections.toggle', $section)" />
                        </td>
                        <td class="px-4 py-2 text-right">
                            <a href="{{ route('admin.sections.edit', $section) }}" class="text-indigo-600 hover:underline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No sections yet. Run SectionSeeder.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
