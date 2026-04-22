<div class="flex flex-wrap gap-3">
    @foreach ($buttons as $button)
        {{-- not-prose prevents Tailwind typography plugin from changing button --}}
        <a @class([$button->class, 'not-prose']) href="{{ $button->url }}"
           @if ($button->open_in_new_tab) target="_blank" @endif>
            {{ $button->content }}
        </a>
    @endforeach
</div>
