<x-layouts.admin
    title="Profile"
    subtitle="Manage your identity, contact details and downloadable assets."
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Profile'],
    ]"
>
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @include('admin.profile._form')

        <div class="sticky bottom-0 z-20 -mx-4 border-t border-slate-200 bg-white/85 px-4 py-3 shadow-[0_-8px_24px_-12px_rgba(15,23,42,0.12)] backdrop-blur-md sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div class="flex items-center justify-end gap-4">
                <p class="mr-auto hidden items-center gap-2 text-xs text-slate-500 sm:flex">
                    <span class="flex size-5 shrink-0 items-center justify-center rounded-full bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                        <svg class="size-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span>Changes are applied to the public portfolio immediately.</span>
                </p>

                <button type="submit"
                    class="group inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-linear-to-b from-indigo-500 to-indigo-600 px-5 text-sm font-semibold text-white shadow-md shadow-indigo-600/25 ring-1 ring-inset ring-indigo-700/40 transition duration-150 hover:from-indigo-500 hover:to-indigo-700 hover:shadow-lg hover:shadow-indigo-600/30 focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-indigo-500/40 active:scale-[0.98]">
                    <svg class="size-4 transition-transform duration-150 group-hover:scale-110" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                    </svg>
                    <span>Save changes</span>
                </button>
            </div>
        </div>
    </form>
</x-layouts.admin>