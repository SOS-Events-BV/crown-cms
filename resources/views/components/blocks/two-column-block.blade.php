<div
    class="relative left-1/2 right-1/2 -mx-[50vw] w-screen my-12 lg:my-20"
    @if($backgroundColor) style="background-color: {{ $backgroundColor }}; padding: 80px 0;" @endif
>
    <div class="container mx-auto">
        <div @class(['grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20', 'items-center' => $centerContent])>
            <div
                @class([$layoutRatio['left'], 'prose-content', 'items-center' => $centerContent, 'space-y-8 lg:space-y-12'])
                @if($textStyle) style="{{ $textStyle }}" @endif
            >
                @forelse ($leftColumn as $block)
                    @php($blockView = str_replace('_', '-', $block->type))
                    @if(view()->exists("crown-cms::components.blocks.{$blockView}"))
                        <x-dynamic-component :component="'crown-cms::blocks.' . $block->type" :data="$block->data"/>
                    @elseif(view()->exists("components.crown-cms.custom-blocks.{$blockView}"))
                        <x-dynamic-component :component="'crown-cms.custom-blocks.' . $block->type" :data="$block->data"/>
                    @endif
                @empty
                    {{-- Empty column --}}
                @endforelse
            </div>

            <div
                @class([$layoutRatio['right'], 'prose-content', 'items-center' => $centerContent, 'space-y-8 lg:space-y-12'])
                @if($textStyle) style="{{ $textStyle }}" @endif
            >
                @forelse ($rightColumn as $block)
                    @php($blockView = str_replace('_', '-', $block->type))
                    @if(view()->exists("crown-cms::components.blocks.{$blockView}"))
                        <x-dynamic-component :component="'crown-cms::blocks.' . $block->type" :data="$block->data"/>
                    @elseif(view()->exists("components.crown-cms.custom-blocks.{$blockView}"))
                        <x-dynamic-component :component="'crown-cms.custom-blocks.' . $block->type" :data="$block->data"/>
                    @endif
                @empty
                    {{-- Empty column --}}
                @endforelse
            </div>
        </div>
    </div>
</div>
