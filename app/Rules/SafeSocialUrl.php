<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/** Only https:// URLs or mailto: addresses. Blocks javascript:, data:, http: etc. */
class SafeSocialUrl implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = (string) $value;

        if (preg_match('/^mailto:/i', $value)) {
            if (! filter_var(substr($value, 7), FILTER_VALIDATE_EMAIL)) {
                $fail('The :attribute must contain a valid email address.');
            }

            return;
        }

        $valid = preg_match('/^https:\/\//i', $value)
            && filter_var($value, FILTER_VALIDATE_URL) !== false;

        if (! $valid) {
            $fail('The :attribute must be an https:// link or a mailto: address.');
        }
    }
}
