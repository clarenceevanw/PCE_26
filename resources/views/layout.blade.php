<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PCE 2026</title>
    <link rel="icon" href="{{ asset('assets/logoAja.png') }}" type="image/x-icon" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/css/tw-elements.min.css" />
    <script src="https://cdn.tailwindcss.com/3.3.0"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.1.13/dist/lenis.css">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://unpkg.com/split-type"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    {{-- @vite(['resources/scss/style.scss', 'resources/ts/interactiveElement.ts', 'resources/css/app.css']) --}}
    @yield('head')
    <style>
        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @font-face {
            font-family: 'Squids';
            src: url('{{ asset('fonts/Game Of Squids.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'OrganettoRegular';
            src: url('{{ asset('fonts/organetto-regular.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'OrganettoUltraLight';
            src: url('{{ asset('fonts/milker/organetto-ultralight.ttf') }}') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'ReturnoftheGrid';
            src: url('{{ asset('fonts/return-of-the-grid.otf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        .font-return-grid {
            font-family: 'ReturnoftheGrid', sans-serif;
        }

        .font-squids {
            font-family: 'Squids', sans-serif;
        }

        .font-organetto {
            font-family: 'OrganettoRegular', sans-serif;
        }

        .font-organetto-light {
            font-family: 'OrganettoUltraLight', sans-serif;
        }

        .text-shadow {
            text-shadow: -2px 2px 14px rgb(255, 255, 255);
        }

        .bg-blur {
            backdrop-filter: blur(13px) brightness(0.85);
            -webkit-backdrop-filter: blur(13px) brightness(0.85);
            box-shadow: none;
        }

        body,
        html {
            overflow-x: hidden !important;
        }


        body {
            background-image: url("{{ asset('assets/welcome-awan.png') }}"), linear-gradient(180deg, rgba(198, 234, 255, 1) 0%, rgba(56, 182, 255, 1) 14%);
            background-color: #C6EAFF;

            /* Make the image cover the container (scales and is cropped instead of stretched) */
            background-size: cover, cover;

            /* allow separate settings per layer */
            background-attachment: fixed, fixed;
            background-repeat: no-repeat, no-repeat;

            /* start image at left; keep gradient fixed */
            background-position: 0% 10%, center top;

            /* slide the first (image) layer right then back left */
            animation: bg-slide 30s ease-in-out infinite;
        }

        @keyframes bg-slide {
            0% {
                background-position: 0% 10%, center top;
            }

            50% {
                background-position: 100% 10%, center top;
            }

            100% {
                background-position: 0% 10%, center top;
            }
        }

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
    <style>
        .swal2-confirm {
            background-color: rgba(45, 72, 56, 1) !important;
            color: white !important;
        }

        .swal2-confirm:hover {
            background-color: rgb(39, 62, 49) !important;
        }

        .swal2-cancel {
            background-color: #e11d48 !important;
            color: white !important;
        }
    </style>

</head>

<body>
    @if (session('login'))
        <script>
            Swal.fire({
                title: "Success",
                text: "{{ session('login') }}",
                icon: "success"
            });
        </script>
    @endif
    @if (session('logout'))
        <script>
            Swal.fire({
                title: "Success",
                text: "{{ session('logout') }}",
                icon: "success"
            });
        </script>
    @endif

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/tw-elements/js/tw-elements.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/Flip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://unpkg.com/lenis@1.1.13/dist/lenis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/MotionPathPlugin.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.8.162/pdf.min.js"></script>
    {{-- <script src="https://unpkg.com/@studio-freight/lenis@1.0.28/dist/lenis.min.js"></script> --}}

    @yield('script')
    <script>
        AOS.init();
    </script>
    {{-- <script>
        const lenis = new Lenis({
            duration: 1.4,   // makin besar = makin lembut
            smooth: true,    // aktifkan efek halus
        });

        // Animasi loop biar smooth scroll aktif
        function raf(time) {
            lenis.raf(time)
            requestAnimationFrame(raf)
        }
        requestAnimationFrame(raf)
    </script> --}}

</body>

</html>
