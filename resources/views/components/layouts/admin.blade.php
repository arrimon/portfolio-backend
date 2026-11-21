@props(['title' => 'Admin', 'breadcrumbs' => []])
@php
    $user = auth()->user();
    $name = $user?->name ?? 'Admin';
    $role = $user?->role?->name ?? 'Administrator';
    $initials = mb_strtoupper(
        collect(preg_split('/\s+/', trim($name)))
            ->filter()
            ->map(fn ($part) => mb_substr($part, 0, 1))
            ->take(2)
            ->implode('')
    );
    $brandInitial = mb_strtoupper(mb_substr(config('app.name'), 0, 1));

    $navGroups = [
        'Overview' => [
            ['label' => 'Dashboard', 'icon' => 'home', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard'],
        ],
        'Content' => [
            ['label' => 'Profile', 'icon' => 'user', 'route' => 'admin.profile.edit', 'pattern' => 'admin.profile.*'],
            ['label' => 'Sections', 'icon' => 'layers', 'route' => 'admin.sections.index', 'pattern' => 'admin.sections.*'],
            ['label' => 'Social links', 'icon' => 'link', 'route' => 'admin.social-links.index', 'pattern' => 'admin.social-links.*'],
        ],
        'Site' => [
            ['label' => 'Settings', 'icon' => 'cog', 'route' => 'admin.settings.edit', 'pattern' => 'admin.settings.*'],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-app min-h-screen bg-slate-100 text-slate-700 antialiased">
<a href="#main"
    class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[60] focus:rounded-lg focus:bg-white focus:px-4 focus:py-2 focus:text-sm focus:font-medium focus:text-slate-900 focus:shadow-md focus:outline-hidden focus:ring-3 focus:ring-indigo-500/30">
    Skip to content
</a>

<div class="min-h-screen lg:pl-64">
    {{-- Sidebar / mobile drawer --}}
    <aside id="admin-sidebar" data-drawer
        class="fixed inset-y-0 left-0 z-50 flex w-64 -translate-x-full flex-col border-r border-slate-800 bg-slate-900 text-slate-300 transition-transform duration-200 ease-out lg:z-40 lg:translate-x-0"
        aria-label="Main navigation">
        <div class="flex h-14 shrink-0 items-center gap-3 border-b border-slate-800 px-4">
            <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-indigo-600 text-sm font-semibold text-white">{{ $brandInitial }}</span>
            <span class="truncate text-sm font-semibold text-white">{{ config('app.name') }}</span>
            <button type="button" data-drawer-close
                class="ml-auto rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-800 hover:text-white focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-indigo-500/30 lg:hidden"
                aria-label="Close navigation">
                <x-ui.icon name="x" class="size-5" />
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4">
            @foreach ($navGroups as $group => $items)
                <p class="px-3 pb-2 pt-4 text-[11px] font-semibold uppercase tracking-wider text-slate-500 first:pt-0">{{ $group }}</p>
                <ul class="space-y-1">
                    @foreach ($items as $item)
                        @php $active = request()->routeIs($item['pattern']); @endphp
                        <li>
                            <a href="{{ route($item['route']) }}"
                                @if ($active) aria-current="page" @endif
                                @class([
                                    'group relative flex h-9 items-center gap-3 rounded-lg px-3 text-sm font-medium transition-colors duration-150 focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-indigo-500/30',
                                    'bg-slate-800 text-white' => $active,
                                    'text-slate-400 hover:bg-slate-800/60 hover:text-slate-100' => ! $active,
                                ])>
                                @if ($active)
                                    <span class="absolute inset-y-1.5 left-0 w-0.5 rounded-full bg-indigo-500" aria-hidden="true"></span>
                                @endif
                                <x-ui.icon :name="$item['icon']" class="size-4 shrink-0" />
                                <span class="pt-2 leading-none">{{ $item['label'] }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endforeach
        </nav>

        <div class="border-t border-slate-800 px-4 py-3">
            <div class="flex items-center justify-between gap-2 text-xs text-slate-400">
                <span>Environment</span>
                <span class="rounded-md bg-slate-800 px-2 py-0.5 font-mono text-[10px] font-medium uppercase tracking-wide text-slate-300 ring-1 ring-slate-700">{{ app()->environment() }}</span>
            </div>
        </div>
    </aside>

    <div data-drawer-overlay class="fixed inset-0 z-40 hidden bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

    <div class="flex min-h-screen flex-col">
        {{-- Topbar --}}
        <header class="sticky top-0 z-30 flex h-14 items-center gap-3 border-b border-slate-200 bg-white/90 px-4 backdrop-blur sm:px-6 lg:px-8">
            <button type="button" data-drawer-toggle aria-controls="admin-sidebar" aria-expanded="false"
                aria-label="Open navigation"
                class="rounded-lg p-1.5 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-indigo-500/30 lg:hidden">
                <x-ui.icon name="menu" class="size-5" />
            </button>

            <div class="hidden min-w-0 flex-1 lg:block">
                <x-admin.breadcrumb :items="$breadcrumbs" />
            </div>

            <div class="ml-auto flex items-center gap-3">
                <div class="flex items-center gap-3">
                    <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-slate-900 text-xs font-semibold text-white">{{ $initials }}</span>
                    <div class="hidden leading-tight sm:block">
                        <p class="max-w-[12rem] truncate text-sm font-medium text-slate-900">{{ $name }}</p>
                    </div>
                    <x-ui.badge variant="muted" class="hidden sm:inline-flex">{{ $role }}</x-ui.badge>
                </div>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <x-ui.button type="submit" variant="secondary" size="sm">
                        <x-ui.icon name="logout" class="size-4" />
                        <span class="hidden sm:inline">Logout</span>
                        <span class="sr-only sm:hidden">Logout</span>
                    </x-ui.button>
                </form>
            </div>
        </header>

        <main id="main" class="flex-1 px-4 pb-24 pt-6 sm:px-6 lg:px-8 lg:pb-28 lg:pt-8">
            <div class="w-full">
                <x-ui.page-header :title="$title" :breadcrumbs="$breadcrumbs" :subtitle="isset($subtitle) ? (string) $subtitle : null">
                    @isset($actions)
                        <x-slot:actions>{{ $actions }}</x-slot:actions>
                    @endisset
                </x-ui.page-header>

                <x-admin.alert />

                {{ $slot }}
            </div>
        </main>
    </div>
</div>
</body>
</html>
