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

        // ✅ FIX: Use ->required() and custom validation via ->afterStateUpdated() or ->rules()
        $this->required();
        
        // Use ->rules() with a string or array instead of ->rule() with a closure
        $this->rules([
            function (string $attribute, mixed $value, \Closure $fail) {
                if ($value && !str_starts_with($value, 'data:image')) {
                    $fail('The image must be a valid base64 image.');
                }
            },
        ]);
    }
}