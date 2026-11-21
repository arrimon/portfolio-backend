@props(['title' => 'Admin', 'breadcrumbs' => []])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title }} — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="hidden w-64 shrink-0 flex-col bg-slate-900 text-slate-200 md:flex">
        <div class="px-6 py-5 text-lg font-semibold text-white">{{ config('app.name') }}</div>
        <nav class="flex-1 space-y-1 px-3" aria-label="Main">
            <a href="{{ route('admin.dashboard') }}"
               @class([
                   'block rounded-md px-3 py-2 text-sm font-medium',
                   'bg-slate-800 text-white' => request()->routeIs('admin.dashboard'),
                   'hover:bg-slate-800' => ! request()->routeIs('admin.dashboard'),
               ])>
                Dashboard
            </a>
            <a href="{{ route('admin.profile.edit') }}"
               @class([
                   'block rounded-md px-3 py-2 text-sm font-medium',
                   'bg-slate-800 text-white' => request()->routeIs('admin.profile.*'),
                   'hover:bg-slate-800' => ! request()->routeIs('admin.profile.*'),
               ])>
                Profile
            </a>
            <a href="{{ route('admin.sections.index') }}"
               @class([
                   'block rounded-md px-3 py-2 text-sm font-medium',
                   'bg-slate-800 text-white' => request()->routeIs('admin.sections.*'),
                   'hover:bg-slate-800' => ! request()->routeIs('admin.sections.*'),
               ])>
                Sections
            </a>
            <a href="{{ route('admin.social-links.index') }}"
               @class([
                   'block rounded-md px-3 py-2 text-sm font-medium',
                   'bg-slate-800 text-white' => request()->routeIs('admin.social-links.*'),
                   'hover:bg-slate-800' => ! request()->routeIs('admin.social-links.*'),
               ])>
                Social links
            </a>
            <a href="{{ route('admin.settings.edit') }}"
               @class([
                   'block rounded-md px-3 py-2 text-sm font-medium',
                   'bg-slate-800 text-white' => request()->routeIs('admin.settings.*'),
                   'hover:bg-slate-800' => ! request()->routeIs('admin.settings.*'),
               ])>
                Settings
            </a>
        </nav>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">
        {{-- Navbar --}}
        <header class="flex items-center justify-between border-b border-slate-200 bg-white px-6 py-3">
            <span class="text-sm text-slate-500 md:hidden">{{ config('app.name') }}</span>
            <div class="ml-auto flex items-center gap-4">
                <span class="text-sm text-slate-600">
                    {{ auth()->user()->name }}
                    <span class="text-xs text-slate-400">({{ auth()->user()->role?->name }})</span>
                </span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                            class="rounded-md border border-slate-300 px-3 py-1.5 text-sm hover:bg-slate-50">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 p-6">
            <x-admin.breadcrumb :items="$breadcrumbs" />
            <h1 class="mb-4 text-2xl font-semibold">{{ $title }}</h1>
            <x-admin.alert />
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
