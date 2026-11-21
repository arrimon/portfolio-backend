<?php

namespace App\Http\Requests\Admin;

use App\Services\LocaleService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // authorization is done by ProfilePolicy in the controller
    }

    public function rules(): array
    {
        $locales = app(LocaleService::class);
        $codes = $locales->codes();
        $default = $locales->defaultCode();

        $rules = [
            'email' => ['nullable', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:150'],
            'is_available_for_work' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'cv' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'translations' => ['required', 'array:'.implode(',', $codes)],
        ];

        foreach ($codes as $code) {
            $rules["translations.{$code}"] = ['nullable', 'array'];
            $rules["translations.{$code}.name"] = [$code === $default ? 'required' : 'nullable', 'string', 'max:150'];
            $rules["translations.{$code}.headline"] = ['nullable', 'string', 'max:200'];
            $rules["translations.{$code}.bio"] = ['nullable', 'string', 'max:5000'];
        }

        return $rules;
    }
}
