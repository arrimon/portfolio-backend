<?php

namespace App\Http\Requests\Admin;

use App\Services\LocaleService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $codes = app(LocaleService::class)->codes();
        $variants = $this->route('section')->key->variants();

        $rules = [
            'variant' => ['nullable', Rule::in($variants)],
            'translations' => ['nullable', 'array:'.implode(',', $codes)],
        ];

        foreach ($codes as $code) {
            $rules["translations.{$code}"] = ['nullable', 'array'];
            $rules["translations.{$code}.title"] = ['nullable', 'string', 'max:150'];
            $rules["translations.{$code}.subtitle"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}
