{{-- @formatter:off --}}
@props([
    'title' => config('app.name'),
    'description' => '',
    'keywords' => null,
    'og_title' => null,
    'og_description' => null,
    'og_image' => null,
])

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        {{-- SEO --}}

        <title>{{ $title }}</title>
        <meta name="description" content="{{ $description }}">

        @if($keywords)
            <meta name="keywords" content="{{ $keywords }}">
        @endif

        {{-- Open Graph (OG) --}}
        <meta property="og:title" content="{{ $og_title ?? $title }}"/>
        <meta property="og:description" content="{{ $og_description ?? $description }}"/>
        @if (isset($og_image))
            <meta property="og:image" content="{{ str_starts_with($og_image, 'http') ? $og_image : asset(Storage::url($og_image)) }}"/>
        @endif
        <meta property="og:type" content="website"/>
        <meta property="og:url" content="{{ url()->current() }}"/>

        {{-- / SEO --}}

        {{-- Styles --}}

        {{-- Change this with your own Vite assets and remove the CDN links --}}
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" ></script>

        {{-- / Styles --}}

        {{-- Weglot --}}

        @if (config('crown-cms.services.weglot.api_key'))
            <script type="text/javascript" src="https://cdn.weglot.com/weglot.min.js"></script>

            <script>
                Weglot.initialize({
                    api_key: '{{ config('crown-cms.services.weglot.api_key') }}'
                });
            </script>
        @endif

        {{-- / Weglot --}}


        @stack('styles')  {{-- Push extra styles from child views --}}
        @stack('head') {{-- For everything else: schemas, meta tags... --}}
    </head>

    <body {{ $attributes }}>
    {{-- Add your own navbar here: --}}
    {{-- <x-navbar /> --}}

    {{ $slot }}


    {{-- Add your own footer here: --}}
    {{-- <x-footer /> --}}

    @stack('scripts') {{-- Push extra scripts from child views --}}
    </body>
</html>
