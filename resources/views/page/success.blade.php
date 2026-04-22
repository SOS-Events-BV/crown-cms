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
    <h1>{{ $title }}</h1>

    <div>{!! $message !!}</div>
@endsection
