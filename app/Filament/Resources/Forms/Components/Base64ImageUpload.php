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

        // ✅ FIX: Only use standard rules. No closures to avoid resolution errors.
        $this->required();
    }
}