<x-dynamic-component
    :component="config('crown-cms.layout')"
    :title="$page->seo?->page_title"
    :description="$page->seo?->page_description"
    :keywords="$page->seo?->page_keywords"
    :og_title="$page->seo?->og_title"
    :og_description="$page->seo?->og_description"
    :og_image="$page->seo?->og_image"
>
    <div class="container py-15 mx-auto">
        <div class="prose">
            @foreach($page->content_objects as $block)
                <x-dynamic-component
                    :component="'crown-cms::blocks.' . $block->type"
                    :data="$block->data"
                />
            @endforeach
        </div>
    </div>
</x-dynamic-component>
