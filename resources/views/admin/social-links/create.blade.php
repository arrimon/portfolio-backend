<x-layouts.admin
    title="Add social link"
    subtitle="Add a profile that should appear on your public portfolio."
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Social links', 'url' => route('admin.social-links.index')],
        ['label' => 'Add'],
    ]"
>
    <form method="POST" action="{{ route('admin.social-links.store') }}" class="mx-auto max-w-2xl">
        @csrf
        @include('admin.social-links._form')
    </form>
</x-layouts.admin>
