<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Phone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // El Salvador phone number regex: 8 digits, can start with +503 or 503, e.g. +503 1234 5678, 50312345678, 1234-5678
        if (! preg_match('/^(\+?503[-.\s]?)?([267][0-9]{3})[-.\s]?([0-9]{4})$/', $value)) {
            $fail('The :attribute must be a valid El Salvador phone number.');
        }
    }
}
