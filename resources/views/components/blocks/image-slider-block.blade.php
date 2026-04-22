<div class="swiper not-prose my-8" data-swiper='@json($config)'>
    <div class="swiper-wrapper">
        @foreach ($images as $image)
            <div class="swiper-slide">
                <img src="{{ Storage::url($image->url) }}" alt="{{ $image->alt ?? "Afbeelding {$loop->iteration}" }}" class="rounded-lg">
            </div>
        @endforeach
    </div>

    @if ($hasNavigation ?? false)
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    @endif

    @if ($hasPagination ?? false)
        <div class="swiper-pagination relative! mt-3"></div>
    @endif
</div>

@push('scripts')
    @vite('resources/js/swiper.js')
@endpush
