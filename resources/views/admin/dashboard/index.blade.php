<x-layouts.admin title="Dashboard" :breadcrumbs="[['label' => 'Dashboard']]">
    <div class="rounded-lg bg-white p-6 shadow-sm">
        <p class="text-slate-700">স্বাগতম, {{ auth()->user()->name }}।</p>
        <p class="mt-1 text-sm text-slate-500">Admin panel-এর foundation প্রস্তুত। পরের module যোগ হলে এখানে তথ্য দেখা যাবে।</p>
    </div>
</x-layouts.admin>
