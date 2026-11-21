<x-layouts.admin
    :title="'Edit section: ' . $section->key->label()"
    subtitle="Update the translated content and choose an approved layout variant."
    :breadcrumbs="[
        ['label' => 'Dashboard', 'url' => route('admin.dashboard')],
        ['label' => 'Sections', 'url' => route('admin.sections.index')],
        ['label' => 'Edit'],
    ]"
>
    <form method="POST" action="{{ route('admin.sections.update', $section) }}" class="max-w-3xl space-y-6">
        @csrf
        @method('PUT')

        @include('admin.sections._form')

        <div class="card-footer rounded-xl border border-slate-200 bg-white shadow-xs">
            <x-ui.button :href="route('admin.sections.index')" variant="ghost">Cancel</x-ui.button>
            <x-ui.button type="submit">Save changes</x-ui.button>
        </div>
    </form>
</x-layouts.admin>
