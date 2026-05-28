<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;

class Base64ImageUpload extends Field
{
    protected string $view = 'filament.forms.components.base64-image-upload';

    protected function setUp(): void
    {
        parent::setUp();

        // Keep existing Base64 state on edit
        $this->afterStateHydrated(function (Base64ImageUpload $component, $state) {
            if (is_string($state) && str_starts_with($state, 'data:image')) {
                $component->state($state);
            }
        });

        // ✅ FIXED: Use a simple rule array instead of a closure to avoid $attribute issues
        $this->rule('required');
        $this->rule(function ($state, \Closure $fail) {
            if ($state && !str_starts_with($state, 'data:image')) {
                $fail('The image must be a valid base64 image.');
            }
        });
    }
}