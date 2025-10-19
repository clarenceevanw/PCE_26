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

        #divisi {
            display: flex;
            /* justify-content: center;
                            align-items: center; */
            min-height: 100vh;
            color: #333;
        }

        .swiper {
            width: 75%;
            padding: 50px 0;

        }

        .swiper-slide {
            position: relative;
            aspect-ratio: 3/4;
            border-radius: 14px;
            border: 1px solid #ddd;
            background: rgb(192, 148, 37);
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
            user-select: none;
        }

        .title {
            position: absolute;
            bottom: 5px;
            left: 50%;
            transform: translate(-50%, 20%);
            -ms-transform: translate(-50%, 20%);
            width: max-content;
            text-align: center;
            padding: 10px 10px;
            background: #333;
            border-radius: 8px;
            border: 2px solid #333;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.5s linear;
        }

        .title span {
            color: #ffd620;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .swiper-slide-active .title {
            bottom: -10px;
            box-shadow: 0 20px 30px 2px rgba(0, 0, 0, 0.1);
        }

        .button-blur {
            backdrop-filter: blur(13px) brightness(0.85);
            -webkit-backdrop-filter: blur(13px) brightness(0.85);
            box-shadow: none;
        }
        .bg-blur {
            backdrop-filter: blur(13px) brightness(0.85);
            -webkit-backdrop-filter: blur(13px) brightness(0.85);
            box-shadow: none;
        }



        @media (max-width: 1100px) {
            .swiper-slide {
                width: 300px;
            }
        }

        @media (max-width: 900px) {
            .swiper-slide {
                width: 250px;
            }
        }

        @media (max-width: 700px) {
            .swiper-slide {
                width: 238px;
            }
        }

        @media (max-width: 610px) {
            .swiper-slide {
                width: 150px;
            }
        }

        .rotate1 {
            transform: rotate(-30deg);
        }

        .rotate2 {
            transform: rotate(30deg);
        }

        .text-shadow {
            text-shadow: 6px 4px 15px #ffffff;
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
        @include('homepage.partials.faq')
        @include('homepage.partials.contact')
        @include('components.joinButton')
    </div>
@endsection
@section('script')
    <script>
        var swiper = new Swiper('.swiper', {
            effect: 'coverflow',
            grabCursor: true,
            centeredSlides: true,
            loop: true,
            initialSlide: 3,
            speed: 600,
            preventClicks: true,
            slidesPerView: "auto",
            coverflowEffect: {
                rotate: 0,
                stretch: 80,
                depth: 350,
                modifier: 1,
                slideShadows: true,
            },
            on: {
                click(event) {
                    swiper.slideTo(event.clickedIndex);
                }
            },
        });
    </script>
@endsection
