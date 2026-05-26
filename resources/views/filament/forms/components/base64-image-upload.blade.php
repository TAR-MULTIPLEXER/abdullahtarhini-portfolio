<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ 
        preview: null, 
        base64: @js($getState()),
        fileName: null,
        handleFile(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            this.fileName = file.name;
            const reader = new FileReader();
            reader.onload = (event) => {
                this.base64 = event.target.result;
                this.preview = URL.createObjectURL(file);
                // Update the field state with Base64
                $wire.set('{{ $field->getStatePath() }}', this.base64);
            };
            reader.readAsDataURL(file);
        },
        remove() {
            this.base64 = null;
            this.preview = null;
            this.fileName = null;
            $wire.set('{{ $field->getStatePath() }}', null);
        }
    }" class="space-y-2">
        
        <!-- Preview -->
        <template x-if="preview">
            <div class="relative">
                <img :src="preview" class="w-full h-48 object-cover rounded-lg border">
                <button 
                    type="button"
                    @click="remove"
                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>
        
        <!-- Upload Button -->
        <div class="flex items-center justify-center w-full">
            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    <p class="text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 5MB</p>
                </div>
                <input 
                    type="file" 
                    class="hidden" 
                    accept="image/*"
                    @change="handleFile"
                />
            </label>
        </div>
        
        <!-- File Name -->
        <template x-if="fileName">
            <p class="text-sm text-gray-600">Selected: <span x-text="fileName"></span></p>
        </template>
        
        <!-- Hidden input to hold Base64 data -->
        <input 
            type="hidden" 
            name="{{ $field->getName() }}" 
            :value="base64"
            x-ref="base64Input"
        />
    </div>
</x-dynamic-component>