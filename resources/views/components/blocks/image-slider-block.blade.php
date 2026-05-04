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

@pushonce('scripts')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"
    />

    <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("[data-swiper]").forEach((el) => {
                const data = JSON.parse(el.dataset.swiper);

                new Swiper(el, {
                    loop: data.loop,
                    spaceBetween: data.spaceBetween,
                    breakpoints: data.breakpoints,
                    modules: [Swiper.Navigation, Swiper.Autoplay, Swiper.Pagination],

                    navigation: data.navigation
                        ? {
                            nextEl: el.querySelector(".swiper-button-next"),
                            prevEl: el.querySelector(".swiper-button-prev"),
                        }
                        : false,

                    autoplay: data.autoplay
                        ? {
                            delay: data.autoplaySpeed,
                            disableOnInteraction: false,
                        }
                        : false,

                    pagination: data.pagination
                        ? {
                            el: el.querySelector(".swiper-pagination"),
                            clickable: true,
                        }
                        : false,
                });
            });
        });
    </script>
@endpushonce
