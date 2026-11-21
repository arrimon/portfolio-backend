@php
    // Forgot Password / social login / Sign up দেখানো হবে কি না।
    // দ্রষ্টব্য: এগুলো শুধু design; এখনো কোনো route বা কাজ নেই। লুকাতে চাইলে false করো।
    $showExtras = true;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#fff6ee">
    <title>Admin Login — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream font-sans text-ink antialiased">
<main class="relative flex min-h-screen flex-col overflow-hidden">

    {{-- পেছনের নরম আলোর বৃত্ত --}}
    <div class="pointer-events-none absolute -left-24 top-8 h-72 w-72 rounded-full bg-peach/40 blur-3xl animate-float-slow"></div>
    <div class="pointer-events-none absolute -right-20 bottom-0 h-80 w-80 rounded-full bg-peach-deep/30 blur-3xl animate-float-slow" style="animation-delay:1.5s"></div>

    <div class="relative mx-auto grid w-full max-w-6xl flex-1 content-center items-center gap-8 px-6 py-10 lg:grid-cols-2 lg:gap-16">

        {{-- ========== Form (mobile-এ নিচে, desktop-এ বামে) ========== --}}
        <section class="order-2 mx-auto w-full max-w-sm lg:order-1">
            <h1 class="animate-fade-up text-center text-3xl font-extrabold leading-tight tracking-tight text-ink lg:text-left">
                Welcome Back!!
            </h1>

            @if (session('success') || session('status') || session('error'))
                <div class="mt-4 animate-fade-up" style="animation-delay:100ms">
                    <x-admin.alert />
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.store') }}" novalidate class="mt-7 space-y-6" id="login-form">
                @csrf

                {{-- Email --}}
                <div class="animate-fade-up" style="animation-delay:150ms">
                    <div class="relative">
                        <label for="email"
                               class="absolute -top-2.5 left-5 z-10 bg-cream px-2 text-xs font-semibold text-stone-600">Email</label>
                        <div @class([
                            'flex items-center gap-3 rounded-full border bg-transparent px-5 py-3 transition duration-200',
                            'border-line focus-within:border-brand focus-within:ring-4 focus-within:ring-peach/60' => ! $errors->has('email'),
                            'border-red-400 focus-within:border-red-500 focus-within:ring-4 focus-within:ring-red-100' => $errors->has('email'),
                        ])>
                            <svg class="h-4 w-4 shrink-0 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="14" rx="3"/><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8 6 8-6"/>
                            </svg>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                   autocomplete="username" placeholder="email@gmail.com" required autofocus
                                   @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
                                   class="w-full min-w-0 bg-transparent text-sm text-ink outline-none placeholder:text-stone-400">
                        </div>
                    </div>
                    @error('email')
                        <p id="email-error" role="alert" class="mt-1.5 pl-5 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="animate-fade-up" style="animation-delay:250ms">
                    <div class="relative">
                        <label for="password"
                               class="absolute -top-2.5 left-5 z-10 bg-cream px-2 text-xs font-semibold text-stone-600">Password</label>
                        <div @class([
                            'flex items-center gap-3 rounded-full border bg-transparent px-5 py-3 transition duration-200',
                            'border-line focus-within:border-brand focus-within:ring-4 focus-within:ring-peach/60' => ! $errors->has('password'),
                            'border-red-400 focus-within:border-red-500 focus-within:ring-4 focus-within:ring-red-100' => $errors->has('password'),
                        ])>
                            <svg class="h-4 w-4 shrink-0 text-stone-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <rect x="5" y="11" width="14" height="9" rx="2.5"/><path stroke-linecap="round" d="M8 11V8a4 4 0 0 1 8 0v3"/>
                            </svg>
                            <input id="password" name="password" type="password"
                                   autocomplete="current-password" placeholder="Enter your password" required
                                   @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                                   class="w-full min-w-0 bg-transparent text-sm text-ink outline-none placeholder:text-stone-400">
                            <button type="button" id="toggle-password" aria-controls="password" aria-label="Show password"
                                    class="-m-1 shrink-0 rounded-full p-1 text-stone-400 transition hover:text-brand focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40">
                                <svg id="eye-open" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>
                                </svg>
                                <svg id="eye-off" class="hidden h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 6.1A9.8 9.8 0 0 1 12 5c6.5 0 10 7 10 7a17 17 0 0 1-3.2 4.1M6.5 6.7C3.7 8.5 2 12 2 12s3.5 7 10 7a9.6 9.6 0 0 0 4-.9"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <p id="password-error" role="alert" class="mt-1.5 pl-5 text-xs font-medium text-red-600">{{ $message }}</p>
                    @enderror

                    <div class="mt-3 flex items-center justify-between gap-3">
                        <label class="flex items-center gap-2 text-xs text-stone-600">
                            <input type="checkbox" name="remember" value="1" @checked(old('remember'))
                                   class="h-3.5 w-3.5 rounded border-line text-brand focus:ring-2 focus:ring-peach-deep focus:ring-offset-0">
                            Remember me
                        </label>
                        @if ($showExtras)
                            <a href="#" class="rounded-sm text-xs font-bold text-brand transition hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40">Forgot Password?</a>
                        @endif
                    </div>
                </div>

                {{-- Login বোতাম --}}
                <div class="animate-fade-up" style="animation-delay:350ms">
                    <button type="submit" id="login-btn"
                            class="w-full rounded-full bg-peach px-4 py-3 text-sm font-bold text-brand shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-peach-deep hover:shadow-lg active:translate-y-0 active:shadow-sm focus:outline-none focus-visible:ring-4 focus-visible:ring-peach-deep/60 disabled:cursor-not-allowed disabled:opacity-70 disabled:hover:translate-y-0 disabled:hover:shadow-sm">
                        Login
                    </button>
                </div>
            </form>

            @if ($showExtras)
                <div class="mt-8 animate-fade-up" style="animation-delay:450ms">
                    <div class="flex items-center gap-3 text-[11px] font-medium text-stone-400">
                        <span class="h-px flex-1 bg-line"></span>
                        <span>or</span>
                        <span class="h-px flex-1 bg-line"></span>
                    </div>

                    <div class="mt-4 flex items-center justify-center gap-5">
                        <button type="button" aria-label="Continue with Google"
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-white/70 text-base font-extrabold text-[#4285F4] shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40">
                            G
                        </button>
                        <button type="button" aria-label="Continue with Facebook"
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-white/70 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40">
                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#1877F2] text-xs font-extrabold leading-none text-white">f</span>
                        </button>
                        <button type="button" aria-label="Continue with Apple"
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-white/70 shadow-sm transition duration-200 hover:-translate-y-0.5 hover:shadow focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40">
                            <svg class="h-4 w-4 text-black" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701"/></svg>
                        </button>
                    </div>

                    <p class="mt-5 text-center text-[11px] text-stone-500">
                        Don't have an account?
                        <a href="#" class="rounded-sm font-bold text-brand transition hover:underline focus:outline-none focus-visible:ring-2 focus-visible:ring-brand/40">Sign up</a>
                    </p>
                </div>
            @endif
        </section>

        {{-- ========== Illustration (mobile-এ উপরে, desktop-এ ডানে) ========== --}}
        <section class="order-1 flex justify-center lg:order-2" aria-hidden="true">
            <div class="relative animate-arch-rise">
                {{-- ছোট ভাসমান বিন্দু --}}
                <span class="absolute -left-6 top-20 h-3 w-3 rounded-full bg-peach-deep animate-float-slow"></span>
                <span class="absolute -right-5 top-36 h-2.5 w-2.5 rounded-full bg-peach animate-float" style="animation-delay:1s"></span>
                <span class="absolute -right-3 top-10 h-1.5 w-1.5 rounded-full bg-brand/40 animate-float-slow" style="animation-delay:2s"></span>

                {{-- 208x288 → 240x320 → 288x416 --}}
                <div class="relative h-72 w-52 select-none sm:h-80 sm:w-60 lg:h-[26rem] lg:w-72">
                    <div class="absolute inset-0 rounded-t-full bg-peach"></div>

                    @if (file_exists(public_path('images/login-hero.png')))
                        {{-- নিজের ছবি রাখলে সেটাই দেখাবে: public/images/login-hero.png --}}
                        <img src="{{ asset('images/login-hero.png') }}" alt=""
                             class="absolute inset-x-0 bottom-0 w-full animate-float object-contain">
                    @else
                        {{-- চরিত্রটি আর্চের নিচে বসে আছে এবং সামান্য নিচে বেরিয়ে আছে --}}
                        <svg viewBox="0 0 280 280" class="absolute -bottom-2 left-1/2 w-full -translate-x-1/2 animate-float" focusable="false">
                            <g transform="translate(-20 -140)">
                                {{-- শরীর --}}
                                <path d="M92 420c0-82 36-122 83-122s83 40 83 122Z" fill="#f7f4ef"/>
                                <path d="M150 300q25 26 50 0" fill="none" stroke="#e5e0d8" stroke-width="4" stroke-linecap="round"/>
                                {{-- গলা --}}
                                <rect x="158" y="262" width="34" height="44" rx="14" fill="#c98a63"/>
                                {{-- মাথা --}}
                                <ellipse cx="175" cy="222" rx="48" ry="55" fill="#dca077"/>
                                {{-- চুল --}}
                                <path d="M127 214c-6-52 32-66 64-56 34 8 42 38 33 58-9-24-32-28-52-26-20 2-36 10-45 24Z" fill="#2b1d18"/>
                                {{-- headphone --}}
                                <path d="M124 222c-8-72 104-84 102 0" fill="none" stroke="#ffffff" stroke-width="9" stroke-linecap="round"/>
                                <rect x="114" y="206" width="20" height="46" rx="10" fill="#ffffff"/>
                                <rect x="216" y="206" width="20" height="46" rx="10" fill="#ffffff"/>
                                {{-- মুখ --}}
                                <circle cx="158" cy="228" r="3.5" fill="#2b1d18"/>
                                <circle cx="194" cy="228" r="3.5" fill="#2b1d18"/>
                                <path d="M165 249q10 9 20 0" fill="none" stroke="#7a4a33" stroke-width="3" stroke-linecap="round"/>
                                {{-- হাতা --}}
                                <path d="M98 330 66 388l42 14 28-56Z" fill="#f7f4ef"/>
                                <path d="M252 330l30 56-40 16-30-52Z" fill="#f7f4ef"/>
                                {{-- laptop --}}
                                <rect x="58" y="352" width="204" height="82" rx="10" fill="#e6e3dd"/>
                                <rect x="72" y="366" width="176" height="54" rx="6" fill="#cfcac2"/>
                                <circle cx="160" cy="393" r="7" fill="#bdb8b0"/>
                                <rect x="44" y="404" width="232" height="14" rx="7" fill="#bdb8b0"/>
                                {{-- হাত --}}
                                <circle cx="92" cy="398" r="13" fill="#dca077"/>
                                <circle cx="236" cy="400" r="13" fill="#dca077"/>
                            </g>
                        </svg>
                    @endif
                </div>
            </div>
        </section>
    </div>
</main>

<script>
    (function () {
        var input = document.getElementById('password');
        var toggle = document.getElementById('toggle-password');
        var eyeOpen = document.getElementById('eye-open');
        var eyeOff = document.getElementById('eye-off');
        if (input && toggle) {
            toggle.addEventListener('click', function () {
                var show = input.type === 'password';
                input.type = show ? 'text' : 'password';
                eyeOpen.classList.toggle('hidden', show);
                eyeOff.classList.toggle('hidden', !show);
                toggle.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
        }

        var form = document.getElementById('login-form');
        var btn = document.getElementById('login-btn');
        if (form && btn) {
            form.addEventListener('submit', function () {
                btn.disabled = true;
                btn.setAttribute('aria-busy', 'true');
                btn.textContent = 'Please wait…';
            });
        }
    })();
</script>
</body>
</html>
