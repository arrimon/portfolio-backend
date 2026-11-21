<x-layouts.admin
    :title="'Edit section: ' . $section->key->label()"
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Sections', 'url' => route('admin.sections.index')],
        ['label' => 'Edit'],
    ]"
>
    <form method="POST" action="{{ route('admin.sections.update', $section) }}" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.sections._form')
        <div class="flex gap-3">
            <button class="rounded bg-indigo-600 px-5 py-2 text-sm font-medium text-white hover:bg-indigo-700">Save</button>
            <a href="{{ route('admin.sections.index') }}" class="px-3 py-2 text-sm text-gray-600">Cancel</a>
        </div>
    </form>
</x-layouts.admin>
