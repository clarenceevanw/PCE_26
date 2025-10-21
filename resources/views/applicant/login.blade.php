<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PCE 2026 | Login</title>
    <link rel="icon" href="{{ asset('assets/logoAja.png') }}">

    {{-- TW Elements --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/css/tw-elements.min.css" />

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com/"></script>

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap');
        @import url("https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap");

        * {
            user-select: none;
            -ms-user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            font-family: 'Lexend', sans-serif;
        }

        html {
            /* overflow: hidden; */
        }

        body {
            /* background-image: url("{{ asset('assets/welcome-awan.webp') }}"), linear-gradient(180deg, rgba(198, 234, 255, 1) 0%, rgba(56, 182, 255, 1) 14%); */
            background: linear-gradient(180deg, rgba(198, 234, 255, 1) 0%, rgba(56, 182, 255, 1) 14%);

            background-color: #C6EAFF;

            background-size: cover, cover;
            background-attachment: fixed, fixed;
            background-repeat: no-repeat, no-repeat;

            background-position: 0% 10%, center top;

            animation: bg-slide 30s ease-in-out infinite;
        }

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


        @keyframes gradient-flow {
            0% {
                background-position: 0% 50%;
            }

            25% {
                background-position: 50% 0%;
            }

            50% {
                background-position: 100% 50%;
            }

            75% {
                background-position: 50% 100%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .logo {
            filter: drop-shadow(0 0 5px white) drop-shadow(0 0 35px white);
            -webkit-filter: drop-shadow(0 0 5px white) drop-shadow(0 0 35px white);
            -ms-filter: drop-shadow(0 0 5px white) drop-shadow(0 0 35px white);

        }



        .swal2-confirm {
            background-color: rgba(45, 72, 56, 1);
        }

        .swal2-deny {
            background-color: rgb(98, 0, 0);
        }

        .button-interact {
            transition: .3s ease;
        }

        .button-interact:hover {
            box-shadow: 0 0 9px white;
        }

        .button-interact:active {
            box-shadow: none;
        }

        .title-text {
            text-shadow: 0 0 5px white;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
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

        .font-squids {
            font-family: 'Squids', sans-serif;
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

        .font-organetto {
            font-family: 'OrganettoRegular', sans-serif;
        }

        .font-organetto-light {
            font-family: 'OrganettoUltraLight', sans-serif;
        }

        .glowing {
            animation: glowing 2s infinite;
        }

        @keyframes glowing {
            0% {
                text-shadow: 0 0 5px rgba(255, 255, 255, 0.8);
            }

            50% {
                text-shadow: 0 0 22px rgba(255, 255, 255, 0.9);
            }

            100% {
                text-shadow: 0 0 5px rgba(255, 255, 255, 0.8);
            }
        }

        .card-glowing-border {
            position: relative;
            background-color: rgba(6, 40, 61, 0.5);
            /* Warna background card, sesuaikan jika perlu */
            backdrop-filter: blur(10px);
            /* Efek blur */
            border: 2px solid transparent;
            /* Border awal transparan */
            border-radius: 0.5rem;
            /* rounded-lg */
            overflow: hidden;
            /* Penting untuk animasi pseudo-element */
        }

        .card-glowing-border::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg,
                    rgba(0, 255, 255, 0.5),
                    /* Cyan */
                    rgba(0, 200, 255, 0.5),
                    /* Light Blue */
                    rgba(0, 255, 255, 0.5));
            /* Cyan kembali */
            background-size: 400% 400%;
            z-index: -1;
            animation: gradientBorder 10s ease infinite alternate;
            /* Animasi berkedip */
            border-radius: 0.5rem;
            /* Sama dengan border-radius card */
        }

        /* [NEW] Keyframes untuk animasi glowing border */
        @keyframes gradientBorder {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @media screen and (max-width: 1000px) {
            body {
                background-size: cover;
            }
        }
    </style>

</head>

<body>
    @if (session()->has('invalidLogin'))
        <script>
            Swal.fire({
                title: "Error",
                text: "{{ session('invalidLogin') }}",
                icon: "error"
            });
        </script>
    @endif
    @if (session()->has('logout'))
        <script>
            Swal.fire({
                title: "Success",
                text: "{{ session('logout') }}",
                icon: "success"
            });
        </script>
    @endif
    @if (session()->has('guest'))
        <script>
            Swal.fire({
                title: "ERROR",
                text: "{{ session('guest') }}",
                icon: "error"
            });
        </script>
    @endif
    <section class="min-h-screen w-full flex justify-center items-center p-4">

        {{-- [UPDATE] Ganti class di sini untuk glowing border --}}
        <div
            class="w-11/12 max-w-[45rem] card-glowing-border 
                    rounded-lg shadow-2xl p-6 md:p-8 flex flex-col items-center space-y-8">

            <h1
                class="font-return-grid mix-blend-lighten glowing text-white drop-shadow-md font-bold 
                       text-xl md:text-5xl text-center uppercase">
                Open Recruitment
                <br>
                Petra Civil Expo 2026
            </h1>

            <a href="{{ route('applicant.auth') }}"
                class="w-full font-organetto text-white button-interact 
                       border-2 border-cyan-400 active:scale-[0.97] font-semibold drop-shadow-2xl 
                       text-lg md:text-3xl rounded-full py-1 md:py-3 text-center">
                Sign In with PCU Email
            </a>
        </div>
    </section>
</body>

</html>
