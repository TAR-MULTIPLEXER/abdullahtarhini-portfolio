<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <input
        type="file"
        name="{{ $field->getName() }}"
        id="{{ $field->getId() }}"
        {{ $field->isRequired() ? 'required' : '' }}
        {{ $field->getExtraAttributeBag() }}
        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
        accept="image/*"
    >
    @if($field->getHelperText())
        <p class="mt-1 text-sm text-gray-500">{{ $field->getHelperText() }}</p>
    @endif
    @error($field->getName())
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</x-dynamic-component>