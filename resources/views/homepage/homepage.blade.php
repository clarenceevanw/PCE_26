@extends('layout')
@section('head')
    <style>
        html {
            scroll-behavior: smooth !important;
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* font-family: 'Courier New', Courier, monospace */
        }

        .text-shadow {
            text-shadow: 6px 4px 15px #ffffff;
        }

        /* body { */
        /* background-image: url("{{ asset('assets/welcome-awan.webp') }}"), linear-gradient(180deg, rgba(198, 234, 255, 1) 0%, rgba(56, 182, 255, 1) 14%); */
        /* background-color: #C6EAFF; */

        /* Make the image cover the container (scales and is cropped instead of stretched) */
        /* background-size: cover, cover; */

        /* allow separate settings per layer */
        /* background-attachment: fixed, fixed; */
        /* background-repeat: no-repeat, no-repeat; */

        /* start image at left; keep gradient fixed */
        /* background-position: 0% 10%, center top; */

        /* slide the first (image) layer right then back left */
        /* animation: bg-slide 30s ease-in-out infinite; */
        /* } */

        /* @keyframes bg-slide {
                                    0% {
                                        background-position: 0% 10%, center top;
                                    }

                                    50% {
                                        background-position: 100% 10%, center top;
                                    }

                                    100% {
                                        background-position: 0% 10%, center top;
                                    }
                                } */

        @media (min-width: 1024px) {
            body {
                background-size: 110% auto, cover;
            }
        }

        @media (min-width: 1920px) {
            body {
                background-size: 200% auto, cover;
            }
        }
    </style>
@endsection
@section('content')
    @include('components.navbar')
    <div class="background flex flex-col overflow-x-hidden">
        @include('homepage.partials.welcome')
        @include('homepage.partials.penjelasan')
        @include('homepage.partials.divisi')
        @include('homepage.partials.requirement')
        @include('homepage.partials.timeline')
        {{-- @include('homepage.partials.faq') --}}
        @include('homepage.partials.contact')
        @include('components.joinButton')
    </div>
@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.swiper', {
                effect: 'coverflow',
                grabCursor: true,
                centeredSlides: true,
                loop: true,
                initialSlide: 6,
                speed: 400,
                slidesPerView: 'auto',
                watchSlidesProgress: true,

                autoplay: {
                    delay: 1000, 
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },

                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 100,
                    modifier: 2.5,
                    slideShadows: false,
                },
                on: {
                    setTranslate: function() {
                        const slides = this.slides;
                        const activeIndex = this.activeIndex;

                        slides.forEach((slide, index) => {
                            const distance = Math.abs(index - activeIndex);

                            if (distance === 0) {
                                slide.style.opacity = '1';
                                slide.style.pointerEvents = 'auto';
                            } else if (distance === 1) {
                                slide.style.opacity = '0.8';
                                slide.style.pointerEvents = 'auto';
                            } else if (distance === 2) {
                                slide.style.opacity = '0.5';
                                slide.style.pointerEvents = 'auto';
                            } else {
                                slide.style.opacity = '0';
                                slide.style.pointerEvents = 'none';
                            }
                        });
                    }
                }
            });

            const cardContainers = document.querySelectorAll('.card-container');

            cardContainers.forEach(container => {
                container.addEventListener('click', function(e) {
                    e.stopPropagation();
                    this.classList.toggle('flipped');

                    // swiper.autoplay.stop();
                    // setTimeout(() => {
                    //     swiper.autoplay.start();
                    // }, 2000);
                });
            });

            document.querySelector('.swiper').addEventListener('click', function(e) {
                if (e.target.closest('.card-container')) {
                    e.stopPropagation();
                }
            });
        });
    </script>
@endsection
