<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PCE 2026 | Admin Login</title>
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
            margin: 0;
            padding: 0;
            min-height: 100vh;
            min-width: 100vw;
            position: relative;
            animation: gradient 15s ease infinite;
        }

        .logo {
            filter: drop-shadow(0 0 5px white) drop-shadow(0 0 35px white);
            -webkit-filter: drop-shadow(0 0 5px white) drop-shadow(0 0 35px white);
            -ms-filter: drop-shadow(0 0 5px white) drop-shadow(0 0 35px white);

        }

        

        .swal2-confirm {
            background-color: rgba(45, 72, 56, 1);
        }

        .swal2-confirm:hover {
            background-color: rgba(45, 72, 56, 0.8);
        }

        .swal2-deny {
            background-color: rgb(98, 0, 0);
        }

        .button-interact {
            transition: .3s ease;
        }

        .button-interact:hover {
            box-shadow: 0 0 9px black;
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
    <section class="w-screen flex justify-center items-center h-screen absolute">
        <div class=" w-full h-[550px] max-sm:h-[320px] p-8 flex flex-col items-center justify-center border border-t-[#000000] border-b-[#000000]">
            <div class="flex flex-col items-center justify-center w-full p-7 max-sm:p-4">
                <h1
                    class="title-text text-black font-bold text-5xl w-[500px] text-center max-sm:text-2xl uppercase max-sm:w-[300px]">
                    Admin Website</h1>
                <h1
                    class="title-text text-black font-bold text-5xl w-[550px] text-center max-sm:text-2xl max-sm:w-[300px]">
                    Petra Civil Expo 2026</h1>
            </div>
            <a href="{{ route('admin.auth') }}"
                class="text-[#000] button-interact border-2 border-[#000000] active:scale-[0.97] font-semibold drop-shadow-2xl text-2xl max-sm:text-base w-[400px] max-sm:w-[230px] rounded-3xl h-[53px] max-sm:h-[42px] flex justify-center items-center">
                Sign In with PCU Email</a>

        </div>
    </section>
</body>

</html>
