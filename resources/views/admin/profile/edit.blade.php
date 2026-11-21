<x-layouts.admin
    title="Profile"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Profile'],
    ]"
>
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.profile._form')
        <button class="rounded bg-indigo-600 px-5 py-2 text-sm font-medium text-white hover:bg-indigo-700">Save</button>
    </form>
</x-layouts.admin>
