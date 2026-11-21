@php
    $avatarUrl = $profile->avatar?->url;
@endphp

<div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
    <div class="lg:col-span-8">
        <x-admin.translation-tabs
            :locales="$locales"
            :model="$profile"
            title="Content"
            :fields="[
                ['name' => 'name', 'label' => 'Full name'],
                ['name' => 'headline', 'label' => 'Headline'],
                ['name' => 'bio', 'label' => 'Bio (plain text)', 'type' => 'textarea'],
            ]" />
    </div>

    <div class="space-y-6 lg:col-span-4">
        <x-ui.card title="Avatar" description="A square image works best; it is cropped to a circle.">
            <div class="flex items-start gap-4">
                <span class="relative flex size-24 shrink-0 items-center justify-center overflow-hidden rounded-full bg-slate-100 ring-1 ring-slate-200">
                    <x-ui.icon name="user" class="absolute size-8 text-slate-400" />
                    <img id="avatar-preview" @if ($avatarUrl) src="{{ $avatarUrl }}" @endif
                        alt="Avatar preview" class="relative size-24 rounded-full object-cover">
                </span>

                <div class="min-w-0 flex-1">
                    <input id="avatar" type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp" class="peer sr-only">
                    <label for="avatar"
                        class="btn btn-secondary btn-sm cursor-pointer peer-focus-visible:ring-3 peer-focus-visible:ring-indigo-500/30">
                        <x-ui.icon name="upload" class="size-4" />
                        Upload
                    </label>
                    <p id="avatar-file-name" class="help truncate">No file selected</p>
                    <p class="help">JPG, PNG or WebP · max 2 MB</p>
                </div>
            </div>

            @error('avatar')
                <p class="field-error" role="alert">
                    <x-ui.icon name="alert-circle" class="mt-px size-3.5 shrink-0" />
                    <span>{{ $message }}</span>
                </p>
            @enderror
            @error('file')
                <p class="field-error" role="alert">
                    <x-ui.icon name="alert-circle" class="mt-px size-3.5 shrink-0" />
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </x-ui.card>

        <x-ui.card title="CV" description="Upload the latest PDF version of your CV.">
            @if ($profile->cv)
                <div class="mb-4 flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2.5">
                    <span class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-white text-red-600 ring-1 ring-slate-200">
                        <x-ui.icon name="document" class="size-5" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-slate-700">{{ $profile->cv->original_name }}</p>
                        <p class="text-xs text-slate-500">PDF document</p>
                    </div>
                    <a href="{{ $profile->cv->url }}" target="_blank" rel="noopener"
                        class="btn btn-ghost btn-icon" aria-label="Open CV in a new tab">
                        <x-ui.icon name="external-link" class="size-4" />
                    </a>
                </div>
            @endif

            <input id="cv" type="file" name="cv" accept=".pdf" class="file-input" data-file-name="#cv-file-name">
            <p id="cv-file-name" class="help"></p>
            <p class="help">PDF · max 5 MB</p>

            @error('cv')
                <p class="field-error" role="alert">
                    <x-ui.icon name="alert-circle" class="mt-px size-3.5 shrink-0" />
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </x-ui.card>

        <x-ui.card title="Details" description="Contact information shown on the public site.">
            <div class="space-y-4">
                <x-ui.form-field name="email" label="Email" for="email">
                    <input id="email" type="email" name="email" value="{{ old('email', $profile->email) }}"
                        autocomplete="email" class="input">
                </x-ui.form-field>

                <x-ui.form-field name="phone" label="Phone" for="phone">
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                        autocomplete="tel" class="input">
                </x-ui.form-field>

                <x-ui.form-field name="location" label="Location" for="location">
                    <input id="location" type="text" name="location" value="{{ old('location', $profile->location) }}"
                        autocomplete="address-level2" class="input">
                </x-ui.form-field>

                <div class="border-t border-slate-200 pt-4">
                    <x-ui.switch name="is_available_for_work" :checked="old('is_available_for_work', $profile->is_available_for_work)"
                        label="Available for work" />
                    <p class="mt-1.5 text-xs text-slate-500">Shows an availability badge on your portfolio.</p>
                </div>
            </div>
        </x-ui.card>
    </div>
</div>

{{-- Avatar crop modal --}}
<div id="avatar-crop-modal" class="fixed inset-0 z-[70] hidden items-center justify-center p-4" role="dialog"
    aria-modal="true" aria-labelledby="avatar-crop-title">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" data-crop-cancel></div>

    <div class="relative flex max-h-full w-full max-w-lg flex-col overflow-hidden rounded-2xl bg-white shadow-2xl ring-1 ring-slate-900/10">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <div>
                <h3 id="avatar-crop-title" class="text-sm font-semibold text-slate-900">Crop avatar</h3>
                <p class="mt-0.5 text-xs text-slate-500">Drag to move, scroll or use the buttons to zoom.</p>
            </div>
            <button type="button" data-crop-cancel
                class="rounded-lg p-1.5 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 focus-visible:outline-hidden focus-visible:ring-3 focus-visible:ring-indigo-500/30"
                aria-label="Close">
                <x-ui.icon name="x" class="size-5" />
            </button>
        </div>

        <div class="bg-slate-100 p-4">
            <div class="mx-auto h-[50vh] max-h-[26rem] w-full overflow-hidden rounded-lg">
                <img id="avatar-crop-image" alt="Image to crop" class="block max-w-full">
            </div>
        </div>

        <div class="flex items-center justify-center gap-1 border-t border-slate-200 px-5 py-3">
            <x-ui.button variant="ghost" size="sm" data-crop-action="zoom-out" aria-label="Zoom out">
                <x-ui.icon name="search" class="size-4" /> −
            </x-ui.button>
            <x-ui.button variant="ghost" size="sm" data-crop-action="zoom-in" aria-label="Zoom in">
                <x-ui.icon name="search" class="size-4" /> +
            </x-ui.button>
            <x-ui.button variant="ghost" size="sm" data-crop-action="rotate" aria-label="Rotate 90 degrees">
                Rotate
            </x-ui.button>
            <x-ui.button variant="ghost" size="sm" data-crop-action="reset" aria-label="Reset">
                Reset
            </x-ui.button>
        </div>

        <div class="flex items-center justify-between gap-3 border-t border-slate-200 bg-slate-50/70 px-5 py-3.5">
            <p id="avatar-crop-error" class="text-xs text-red-600" role="alert"></p>
            <div class="ml-auto flex items-center gap-2">
                <x-ui.button variant="secondary" data-crop-cancel>Cancel</x-ui.button>
                <x-ui.button data-crop-apply>Apply crop</x-ui.button>
            </div>
        </div>
    </div>
</div>