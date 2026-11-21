<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-100 px-4">
    <div class="w-full max-w-sm rounded-lg bg-white p-8 shadow">
        <h1 class="mb-6 text-xl font-semibold text-slate-800">Admin Login</h1>

        <x-admin.alert />

        <form method="POST" action="{{ route('admin.login.store') }}" novalidate>
            @csrf
            <x-form.input name="email" label="Email" type="email" autocomplete="username" required autofocus />
            <x-form.input name="password" label="Password" type="password" autocomplete="current-password" required />

            <label class="mb-4 flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="rounded border-slate-300">
                আমাকে মনে রাখো
            </label>

            <button type="submit"
                    class="w-full rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                Login
            </button>
        </form>
    </div>
</body>
</html>
