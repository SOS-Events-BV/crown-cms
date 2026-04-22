@props(['name', 'label' => null, 'options' => [], 'required' => false])

<div class="flex flex-col gap-2 w-full">
    @if ($label)
        <label class="text-gray-500">
            {{ $label }}
        </label>
    @endif

    @foreach ($options as $option)
        <div class="flex items-center gap-2">
            <input type="radio" name="{{ $name }}" value="{{ $option->value }}"
                id="{{ $name }}_{{ $option->value }}" @checked(old($name) == $option->value)
                {{ $required ? 'required' : null }} />
            <label for="{{ $name }}_{{ $option->value }}" class="text-gray-700 cursor-pointer">
                {{ $option->label }}
            </label>
        </div>
    @endforeach

    @error($name)
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
