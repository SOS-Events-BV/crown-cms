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
            <h1>{{ $title }}</h1>

            <div>{!! $message !!}</div>
        </div>
    </div>
</x-dynamic-component>
