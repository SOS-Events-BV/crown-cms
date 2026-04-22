@props(['name', 'label' => null, 'value' => null, 'required' => false])

<div class="flex flex-col gap-1 w-full">
    @if ($label)
        <label class="text-gray-500" for="{{ $name }}">
            {{ $label }}
        </label>
    @endif

    <textarea name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->class([
            'border py-2 px-5 rounded-lg',
            'border-gray-400' => !$errors->has($name),
            'border-red-500 bg-red-50' => $errors->has($name),
        ]) }}
        {{ $required ? 'required' : null }} rows="4">{{ old($name, $value) }}</textarea>

    @error($name)
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
