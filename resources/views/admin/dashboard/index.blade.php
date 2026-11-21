<x-layouts.admin title="Dashboard" :breadcrumbs="[['label' => 'Dashboard']]"
    subtitle="A snapshot of your portfolio administration workspace.">
    <div class="card">
        <div class="card-body-lg">
            <p class="text-sm text-slate-700">স্বাগতম, {{ auth()->user()->name }}।</p>
            <p class="mt-1 text-sm text-slate-500">Admin panel-এর foundation প্রস্তুত। পরের module যোগ হলে এখানে তথ্য দেখা যাবে।</p>
        </div>
    </div>

    @php
        $quickLinks = [
            ['label' => 'Profile', 'description' => 'Name, headline, bio, avatar and CV.', 'icon' => 'user', 'route' => 'admin.profile.edit'],
            ['label' => 'Sections', 'description' => 'Enable, order and customize homepage sections.', 'icon' => 'layers', 'route' => 'admin.sections.index'],
            ['label' => 'Social links', 'description' => 'Manage the links shown across your site.', 'icon' => 'link', 'route' => 'admin.social-links.index'],
            ['label' => 'Settings', 'description' => 'Site title, SEO defaults and theme options.', 'icon' => 'cog', 'route' => 'admin.settings.edit'],
        ];
    @endphp

    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($quickLinks as $link)
            <a href="{{ route($link['route']) }}"
                class="group card p-5 transition-colors duration-150 hover:border-indigo-200 hover:shadow-md focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-indigo-500/30">
                <span class="flex size-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <x-ui.icon :name="$link['icon']" class="size-5" />
                </span>
                <h2 class="mt-4 text-sm font-semibold text-slate-900">{{ $link['label'] }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $link['description'] }}</p>
                <span class="mt-4 inline-flex items-center gap-1 text-xs font-medium text-indigo-600">
                    Open
                    <x-ui.icon name="arrow-right" class="size-3.5 transition-transform duration-150 group-hover:translate-x-0.5" />
                </span>
            </a>
        @endforeach
    </div>
</x-layouts.admin>
