<x-layouts.admin
    title="Sections"
    subtitle="Control the order, visibility and layout of every homepage section."
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Sections'],
    ]"
>
    @php
        $ids = $sections->pluck('id')->all();
        $sectionIcons = [
            'hero' => 'sparkles',
            'about' => 'user',
            'skills' => 'code',
            'experience' => 'briefcase',
            'education' => 'academic-cap',
            'projects' => 'folder',
            'services' => 'wrench',
            'testimonials' => 'chat',
            'blog' => 'document',
            'contact' => 'mail',
        ];
    @endphp

    <x-ui.card :padded="false">
        <x-slot:header>
            <div class="flex w-full items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm font-semibold text-slate-900">Homepage sections</h2>
                    <p class="mt-0.5 text-sm text-slate-500">Enable, order and customize what appears on the homepage</p>
                </div>
                <x-ui.badge variant="muted" class="shrink-0">{{ $sections->count() }} sections</x-ui.badge>
            </div>
        </x-slot:header>

        <x-ui.table>
            <x-slot:head>
                <tr>
                    <th scope="col" class="!py-2">Order</th>
                    <th scope="col" class="!py-2">Section</th>
                    <th scope="col" class="!py-2">Title</th>
                    <th scope="col" class="!py-2">Variant</th>
                    <th scope="col" class="!py-2">Visible</th>
                    <th scope="col" class="!py-2 text-right">Actions</th>
                </tr>
            </x-slot:head>

            @forelse ($sections as $i => $section)
                <tr @class(['opacity-60' => ! $section->is_enabled])>
                    <td class="!py-1.5">
                        <div class="flex items-center gap-0.5">
                            @foreach (['up' => [-1, 'arrow-up'], 'down' => [1, 'arrow-down']] as $dir => [$delta, $icon])
                                @if (isset($ids[$i + $delta]))
                                    @php
                                        $new = $ids;
                                        [$new[$i], $new[$i + $delta]] = [$new[$i + $delta], $new[$i]];
                                    @endphp
                                    <form method="POST" action="{{ route('admin.sections.reorder') }}" class="inline-flex">
                                        @csrf
                                        @foreach ($new as $id)
                                            <input type="hidden" name="order[]" value="{{ $id }}">
                                        @endforeach
                                        <x-ui.button type="submit" variant="ghost" size="icon" class="!size-6" aria-label="Move {{ $dir }}">
                                            <x-ui.icon :name="$icon" class="size-3.5" />
                                        </x-ui.button>
                                    </form>
                                @else
                                    <span class="inline-flex size-6 items-center justify-center rounded-lg text-slate-300" aria-hidden="true">
                                        <x-ui.icon :name="$icon" class="size-3.5" />
                                    </span>
                                @endif
                            @endforeach
                        </div>
                    </td>

                    <td class="!py-1.5">
                        <div class="flex items-center gap-2">
                            <span class="cell-icon__badge shrink-0">
                                <x-ui.icon :name="$sectionIcons[$section->key->value] ?? 'layers'" />
                            </span>

                            <div class="pt-2 flex min-w-0 items-center gap-2">
                                <span class="font-medium text-slate-900">
                                    {{ $section->key->label() }}
                                </span>

                                <span class="font-mono text-xs text-slate-500">
                                    {{ $section->key->value }}
                                </span>

                                @unless ($section->is_enabled)
                                    <x-ui.badge variant="muted">Hidden</x-ui.badge>
                                @endunless
                            </div>
                        </div>
                    </td>

                    <td class="max-w-[16rem] !py-1.5">
                        <span class="block truncate text-slate-600" title="{{ $section->t('title') ?? '—' }}">{{ $section->t('title') ?? '—' }}</span>
                    </td>

                    <td class="!py-1.5">
                        <x-ui.badge variant="muted">{{ $section->variant ?? 'default' }}</x-ui.badge>
                    </td>

                    <td class="!py-1.5">
                        <x-admin.toggle-switch :on="$section->is_enabled" :action="route('admin.sections.toggle', $section)"
                            :label="'Toggle visibility of ' . $section->key->label()" />
                    </td>

                    <td class="!py-1.5 text-right">
                        <x-ui.button :href="route('admin.sections.edit', $section)" variant="secondary" size="sm">Edit</x-ui.button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-5 py-10">
                        <x-ui.empty-state title="No sections yet" message="Run the section seeder to create the default homepage sections." />
                    </td>
                </tr>
            @endforelse
        </x-ui.table>
    </x-ui.card>
</x-layouts.admin>