<div x-data="{ open: false }">
    <div>
        {!! $content1 !!}
    </div>

    <div x-show="open" x-transition>
        {!! $content2 !!}
    </div>

    <button :class="open ? 'btn' : 'btn btn-blue'" @click="open = !open"
            x-text="open ? 'Lees minder' : 'Lees meer'"></button>
</div>
