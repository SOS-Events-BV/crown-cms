@props(['name', 'label' => null, 'value' => '1', 'required' => false])

<div class="flex items-center gap-2 w-full">
    <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
        @checked(old($name)) {{ $required ? 'required' : null }} />
    @if ($label)
        <label class="text-gray-500 cursor-pointer" for="{{ $name }}">
            {{ $label }}
        </label>
    @endif

    @error($name)
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
