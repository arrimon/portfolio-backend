<x-layouts.admin
    title="Social links"
    subtitle="Manage the links shown in your public footer and contact areas."
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Social links'],
    ]"
>
    @php
        $ids = $links->pluck('id')->all();
        $platforms = config('portfolio.social_platforms');
        $platformIcons = [
            'github' => 'github',
            'linkedin' => 'linkedin',
            'x' => 'twitter',
            'facebook' => 'facebook',
            'instagram' => 'instagram',
            'youtube' => 'youtube',
            'email' => 'mail',
            'website' => 'globe',
        ];
    @endphp

    <x-ui.card :padded="false">
        <x-slot:header>
            <div class="flex w-full flex-wrap items-center justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <h2 class="text-sm font-semibold text-slate-900">Social links</h2>
                    <p class="mt-0.5 text-sm text-slate-500">Manage the links shown in your public footer and contact areas.</p>
                </div>
                <div class="flex shrink-0 items-center gap-2">
                    <x-ui.badge variant="muted">{{ $links->count() }} links</x-ui.badge>
                    <x-ui.button :href="route('admin.social-links.create')">
                        <x-ui.icon name="plus" class="size-4" />
                        Add link
                    </x-ui.button>
                </div>
            </div>
        </x-slot:header>

        <x-ui.table>
            <x-slot:head>
                <tr>
                    <th scope="col">Order</th>
                    <th scope="col">Platform</th>
                    <th scope="col">URL</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-right">Actions</th>
                </tr>
            </x-slot:head>

            @forelse ($links as $i => $link)
                <tr class="[&>td]:py-2!">
                    <td>
                        <div class="flex items-center gap-0.5">
                            @foreach (['up' => [-1, 'arrow-up'], 'down' => [1, 'arrow-down']] as $dir => [$delta, $icon])
                                @if (isset($ids[$i + $delta]))
                                    @php
                                        $new = $ids;
                                        [$new[$i], $new[$i + $delta]] = [$new[$i + $delta], $new[$i]];
                                    @endphp
                                    <form method="POST" action="{{ route('admin.social-links.reorder') }}" class="inline-flex">
                                        @csrf
                                        @foreach ($new as $id)
                                            <input type="hidden" name="order[]" value="{{ $id }}">
                                        @endforeach
                                        <x-ui.button type="submit" variant="ghost" size="icon" class="size-7!" aria-label="Move {{ $dir }}">
                                            <x-ui.icon :name="$icon" class="size-3.5" />
                                        </x-ui.button>
                                    </form>
                                @else
                                    <span class="inline-flex size-7 items-center justify-center rounded-lg text-slate-300" aria-hidden="true">
                                        <x-ui.icon :name="$icon" class="size-3.5" />
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </td>

                    <td class="align-middle">
                        <div class="flex min-h-8 items-center gap-2">
                            <span class="inline-flex size-8 shrink-0 items-center justify-center">
                                <x-ui.icon
                                    :name="$platformIcons[$link->platform] ?? 'globe'"
                                    class="size-4"
                                />
                            </span>

                            <span class="pt-2 font-medium leading-none text-slate-900">
                                {{ $platforms[$link->platform] ?? $link->platform }}
                            </span>
                        </div>
                    </td>

                    <td>
                        <a href="{{ $link->url }}" target="_blank" rel="noopener"
                            class="group inline-flex max-w-xs items-center gap-1.5 font-mono text-xs text-slate-600 transition-colors hover:text-indigo-600"
                            title="{{ $link->url }}">
                            <span class="truncate">{{ $link->url }}</span>
                            <x-ui.icon name="external-link" class="size-3.5 shrink-0 opacity-0 transition-opacity group-hover:opacity-100" />
                        </a>
                    </td>

                    <td>
                        <x-ui.badge :variant="$link->is_active ? 'success' : 'muted'" :dot="true">
                            {{ $link->is_active ? 'Active' : 'Inactive' }}
                        </x-ui.badge>
                    </td>

                    <td class="text-right">
                        <div class="flex items-center justify-end gap-0.5">
                            <x-ui.button :href="route('admin.social-links.edit', $link)" variant="ghost" size="icon"
                                class="size-7!"
                                aria-label="Edit {{ $platforms[$link->platform] ?? $link->platform }} link" title="Edit">
                                <x-ui.icon name="pencil" class="size-4" />
                            </x-ui.button>

                            <form method="POST" action="{{ route('admin.social-links.destroy', $link) }}" class="inline-flex"
                                onsubmit="return confirm('Delete this link?')">
                                @csrf
                                @method('DELETE')
                                <x-ui.button type="submit" variant="ghost" size="icon"
                                    class="size-7! text-red-600 hover:bg-red-50 hover:text-red-700"
                                    aria-label="Delete {{ $platforms[$link->platform] ?? $link->platform }} link" title="Delete">
                                    <x-ui.icon name="trash" class="size-4" />
                                </x-ui.button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-10">
                        <x-ui.empty-state title="No social links yet"
                            message="Add your GitHub, LinkedIn, email or any other profile you want to display.">
                            <x-ui.button :href="route('admin.social-links.create')">
                                <x-ui.icon name="plus" class="size-4" />
                                Add your first link
                            </x-ui.button>
                        </x-ui.empty-state>
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </x-ui.card>
</x-layouts.admin>