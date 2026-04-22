@extends(config('crown-cms.layout'))

@isset($page->seo)
    {{-- Meta --}}
    @section('title', $page->seo->page_title)
    @section('description', $page->seo->page_description)
    @section('keywords', $page->seo->page_keywords)

    {{-- OG --}}
    @section('og_title', $page->seo->og_title)
    @section('og_description', $page->seo->og_description)
    @section('og_image', $page->seo->og_image)
@endisset

@section('content')
    @foreach($page->content_objects as $block)
        <x-dynamic-component :component="'blocks.' . $block->type" :data="$block->data"/>
    @endforeach
@endsection
