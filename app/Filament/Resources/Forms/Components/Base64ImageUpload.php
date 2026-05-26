<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Storage;

class Base64ImageUpload extends Field
{
    protected string $view = 'filament.forms.components.base64-image-upload';

   public function getValidationRules(): array
{
    return [
        'required',
        // Remove 'image' rule since we're sending Base64, not a file
        'max:7000000', // ~5MB in Base64 (Base64 is ~33% larger than binary)
    ];
}
   protected function setUp(): void
{
    parent::setUp();

    $this->afterStateHydrated(function (Base64ImageUpload $component, $state) {
        // If state is already Base64, keep it
        if (is_string($state) && str_starts_with($state, 'data:image')) {
            $component->state($state);
        }
    });

    // Custom validation to ensure it's a valid Base64 image
    $this->rule(function ($attribute, $value, $fail) {
        if (empty($value)) {
            $fail('The ' . $attribute . ' is required.');
            return;
        }
        
        if (!str_starts_with($value, 'data:image')) {
            $fail('The ' . $attribute . ' must be a valid image.');
            return;
        }
        
        // Verify it's actually Base64
        $base64Data = substr($value, strpos($value, ',') + 1);
        if (base64_decode($base64Data, true) === false) {
            $fail('The ' . $attribute . ' must be a valid image.');
        }
    });
}
}