<?php

// app/Rules/UniqueProjectSlug.php
namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueProjectSlug implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table('projects')
            ->where('slug', $value)
            ->exists();
            
        if ($exists) {
            $fail('The slug already exists.');
        }
    }
}
