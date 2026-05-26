<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div x-data="{ 
        preview: @js(str_starts_with($getState() ?? '', 'data:image') ? $getState() : null),
        handleFile(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                const result = ev.target.result;
                this.preview = result;
                // Use Livewire's $set to update the field
                $wire.set('{{ $getStatePath() }}', result);
            };
            reader.readAsDataURL(file);
        },
        remove() {
            this.preview = null;
            $wire.set('{{ $getStatePath() }}', null);
        }
    }" class="space-y-3">
        
        <!-- Preview -->
        <template x-if="preview">
            <div class="relative rounded-lg overflow-hidden border bg-gray-100">
                <img :src="preview" class="w-full h-40 object-cover">
                <button 
                    type="button"
                    @click="remove"
                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </template>
        
        <!-- Upload Button -->
        <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
            <div class="flex flex-col items-center justify-center py-4">
                <svg class="w-6 h-6 text-gray-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-xs text-gray-600 font-medium">Click to upload image</p>
            </div>
            <input type="file" class="hidden" accept="image/*" @change="handleFile" />
        </label>
    </div>
</x-dynamic-component>