<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Models\Setting;
use App\Services\Admin\SettingService;
use App\Services\LocaleService;
use Illuminate\Support\Facades\Gate;

class SettingController extends Controller
{
    public function __construct(private SettingService $settings, private LocaleService $locales) {}

    public function edit()
    {
        Gate::authorize('view', Setting::class);

        return view('admin.settings.edit', [
            'settings' => $this->settings->forAdmin(),
            'locales' => $this->locales->active(),
        ]);
    }

    public function update(UpdateSettingsRequest $request)
    {
        Gate::authorize('update', Setting::class);

        $this->settings->update($request->validated());

        return redirect()->route('admin.settings.edit')->with('success', 'Settings saved.');
    }
}
