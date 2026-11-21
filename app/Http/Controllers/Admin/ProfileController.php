<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Services\Admin\ProfileService;
use App\Services\LocaleService;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller
{
    public function __construct(private ProfileService $profiles, private LocaleService $locales) {}

    public function edit()
    {
        $profile = $this->profiles->get();
        Gate::authorize('view', $profile);

        return view('admin.profile.edit', [
            'profile' => $profile,
            'locales' => $this->locales->active(),
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $profile = $this->profiles->get();
        Gate::authorize('update', $profile);

        $this->profiles->update($profile, $request->validated(), $request->file('avatar'), $request->file('cv'));

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated.');
    }
}
