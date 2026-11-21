<?php

namespace App\Http\Requests\Admin;

use App\Rules\SafeSocialUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSocialLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'platform' => ['required', Rule::in(array_keys(config('portfolio.social_platforms')))],
            'url' => ['required', 'string', 'max:500', new SafeSocialUrl],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
