<x-layouts.admin
    title="Edit social link"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Social links', 'url' => route('admin.social-links.index')],
        ['label' => 'Edit'],
    ]"
>
    <form method="POST" action="{{ route('admin.social-links.update', $link) }}" class="max-w-xl space-y-5 rounded-lg border border-gray-200 bg-white p-4">
        @csrf
        @method('PUT')
        @include('admin.social-links._form')
    </form>
</x-layouts.admin>
