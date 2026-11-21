<x-layouts.admin
    title="Edit social link"
    subtitle="Update the platform, URL or visibility of this link."
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Social links', 'url' => route('admin.social-links.index')],
        ['label' => 'Edit'],
    ]"
>
    <form method="POST" action="{{ route('admin.social-links.update', $link) }}" class="mx-auto max-w-2xl">
        @csrf
        @method('PUT')
        @include('admin.social-links._form')
    </form>
</x-layouts.admin>
