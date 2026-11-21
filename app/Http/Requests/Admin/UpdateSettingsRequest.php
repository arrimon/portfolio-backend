<?php

namespace App\Http\Requests\Admin;

use App\Services\LocaleService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $codes = app(LocaleService::class)->codes();
        $rules = ['translated' => ['nullable', 'array'], 'plain' => ['nullable', 'array']];

        foreach (config('portfolio.settings') as $definitions) {
            foreach ($definitions as $key => $def) {
                $max = $def['max'] ?? 255;

                if ($def['translatable']) {
                    foreach ($codes as $code) {
                        $rules["translated.{$key}.{$code}"] = ['nullable', 'string', "max:{$max}"];
                    }

                    continue;
                }

                $rule = ['nullable', 'string', "max:{$max}"];
                if (isset($def['in'])) {
                    $rule[] = Rule::in($def['in']);
                }
                if (! empty($def['email'])) {
                    $rule[] = 'email';
                }
                $rules["plain.{$key}"] = $rule;
            }
        }

        return $rules;
    }
}
