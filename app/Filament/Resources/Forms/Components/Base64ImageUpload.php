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
            'image',
            'max:5120', // 5MB
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
    }
}