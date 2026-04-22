<div
    class="relative left-1/2 right-1/2 -mx-[50vw] w-screen my-12 lg:my-20"
    @if($backgroundColor) style="background-color: {{ $backgroundColor }}; padding: 80px 0;" @endif
>
    <div class="container">
        <div @class(['grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20', 'items-center' => $centerContent])>
            <div
                @class([$layoutRatio['left'], 'prose-content', 'items-center' => $centerContent, 'space-y-8 lg:space-y-12'])
                @if($textStyle) style="{{ $textStyle }}" @endif
            >
                @forelse ($leftColumn as $block)
                    <x-dynamic-component :component="'blocks.' . $block->type" :data="$block->data"/>
                @empty
                    {{-- Empty column --}}
                @endforelse
            </div>

            <div
                @class([$layoutRatio['right'], 'prose-content', 'items-center' => $centerContent, 'space-y-8 lg:space-y-12'])
                @if($textStyle) style="{{ $textStyle }}" @endif
            >
                @forelse ($rightColumn as $block)
                    <x-dynamic-component :component="'blocks.' . $block->type" :data="$block->data"/>
                @empty
                    {{-- Empty column --}}
                @endforelse
            </div>
        </div>
    </div>
</div>
