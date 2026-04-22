@props(['name', 'type' => 'text', 'label' => null, 'value' => null, 'required' => false])

<div class="flex flex-col gap-1 w-full">
    @if ($label)
        <label class="text-gray-500" for="{{ $name }}">
            {{ $label }}
        </label>
    @endif

    <input name="{{ $name }}" type="{{ $type }}" id="{{ $name }}" value="{{ old($name, $value) }}"
        {{ $attributes->class([
            'border py-2 px-5 rounded-lg',
            'border-gray-400' => !$errors->has($name), // If there is no error, add the gray border
            'border-red-500 bg-red-50' => $errors->has($name), // If there is an error, add the red border
        ]) }}
        {{ $required ? 'required' : null }}>

    {{-- Show error if there is a error --}}
    @error($name)
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
