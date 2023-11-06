<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RSBSANoFormat implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!preg_match('/^\w{2}-\d{2}-\d{2}-\d{3}-\d{6}$/', $value)) {
            $fail('The RSBSA No. must be in this format 00-00-00-000-00000.');
        }
    }
}
