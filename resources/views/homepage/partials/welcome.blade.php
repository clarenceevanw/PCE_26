<style>
    body {
        overflow-x: hidden;
    }

    #hero {
        position: relative;
        overflow: visible;
    }

    .building-left {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 60vh;
        width: auto;
        object-fit: contain;
        object-position: bottom left;
        z-index: 2;
    }

    .building-right {
        position: absolute;
        right: 0;
        bottom: 0;
        height: 60vh;
        width: auto;
        object-fit: contain;
        object-position: bottom right;
        z-index: 2;
    }

    .the-left-of-right-building {
        position: absolute;
        bottom: 0;
        right: 20%;
        height: 60vh;
        width: auto;
        object-fit: contain;
        object-position: bottom left;
        z-index: 2;
    }

    .land-center {
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100%;
        max-width: 1200px;
        height: auto;
        object-fit: contain;
        z-index: 1;
    }

    .cloud-bottom {
        position: absolute;
        bottom: -20vh;
        width: auto;
        height: 150vh;
        object-fit: contain;
        z-index: 5;
        opacity: 0.95;
    }

    .cloud-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        z-index: 0;
    }

    @keyframes floatCloud1 {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes floatCloud2 {

        0%,
        100% {
            transform: translateX(-50%) translateY(0);
        }

        50% {
            transform: translateX(-50%) translateY(-15px);
        }
    }

    @keyframes floatCloud3 {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-12px);
        }
    }

    #left-right-tree {
        z-index: 3;

    }

    .hero-content {
        position: relative;
        z-index: 10;
        /* padding-bottom: 10rem; */
        padding-bottom: 8rem;
    }

    .gradient-button {
        position: relative;
        display: inline-block;
        padding: 1rem 2.5rem;
        font-size: 1.125rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        background: #fff;
        border: none;
        border-radius: 9999px;
        color: #10b981;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4),
            0 0 0 0 rgba(16, 185, 129, 0.5);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        cursor: pointer;
    }

    .gradient-button::before {
        content: '';
        position: absolute;
        inset: -3px;
        border-radius: 9999px;
        padding: 3px;
        background: linear-gradient(135deg, #34d399, #6ee7b7, #10b981);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .gradient-button::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s ease, height 0.6s ease;
    }

    .gradient-button:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.6),
            0 0 0 8px rgba(255, 255, 255, 0.3);
        background: #fff;
        color: #059669;
    }

    .gradient-button:hover::before {
        opacity: 1;
    }

    .gradient-button:hover::after {
        width: 300px;
        height: 300px;
    }

    .gradient-button:active {
        transform: translateY(0) scale(0.98);
    }

    .gradient-button span {
        position: relative;
        z-index: 1;
    }

    /* Shimmer effect */
    .gradient-button-shimmer {
        position: relative;
        overflow: hidden;
    }

    .gradient-button-shimmer::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent);
        transition: left 0.5s ease;
    }

    .gradient-button-shimmer:hover::before {
        left: 100%;
    }

    .plane {
        position: absolute;
        top: 80%;
        left: -10%;
        width: 150px;
        height: auto;
        z-index: 0;
        animation: flyPlane 8s linear infinite;
    }

    @keyframes flyPlane {
        0% {
            left: -10%;
            top: 70%;
            transform: translate(0, -60px);
        }

        50% {
            transform: translate(20px, -20px);
        }

        100% {
            left: 110%;
            top: 30%;
            transform: translate(0, 0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .the-left-of-right-building {
            right: 2%;
        }

        .building-right {
            bottom: -0.5rem;
        }

        .plane {
            width: 80px;
            height: auto;
            top: 80%;
            left: -20%;
        }

        @keyframes flyPlane {
            0% {
                left: -30%;
                top: 90%;
                transform: translate(0, -60px);
            }

            50% {
                transform: translate(20px, -20px);
            }

            100% {
                left: 110%;
                top: 70%;
                transform: translate(0, 0);
            }
        }

        .cloud-bottom {
            bottom: -70vh;
            height: 150vh;
        }
    }

    @media (max-width: 1024px) {
        .cloud-bottom {
            bottom: -75vh;
            height: 150vh;
        }
    }

    @media (max-width: 768px) {

        .building-left,
        .building-right,
        .the-left-of-right-building {
            height: 40vh;
        }

        .the-left-of-right-building {
            right: 2%;
        }

        .building-right {
            bottom: -0.5rem;
        }

        .land-center {
            max-width: 100%;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            padding-bottom: 10rem;
        }

        .plane {
            width: 80px;
            height: auto;
            top: 80%;
            left: -20%;
        }

        @keyframes flyPlane {
            0% {
                left: -30%;
                top: 90%;
                transform: translate(0, -60px);
            }

            50% {
                transform: translate(20px, -20px);
            }

            100% {
                left: 110%;
                top: 70%;
                transform: translate(0, 0);
            }
        }

        .cloud-bottom {
            bottom: -75vh;
            height: 150vh;
        }

    }

    @media (max-width: 480px) {

        .building-left,
        .building-right,
        .the-left-of-right-building {
            height: 30vh;
        }

        .building-right {
            bottom: -0.5rem;
        }

        .the-left-of-right-building {
            right: 2%;
        }

        .hero-content {
            padding-bottom: 6rem;
        }

        .plane {
            width: 80px;
            height: auto;
            top: 80%;
            left: -20%;
        }

        @keyframes flyPlane {
            0% {
                left: -30%;
                top: 100%;
                transform: translate(0, -60px);
            }

            50% {
                transform: translate(20px, -20px);
            }

            100% {
                left: 110%;
                top: 80%;
                transform: translate(0, 0);
            }
        }

        .cloud-bottom {
            bottom: -75vh;
            height: 150vh;
        }

    }

    @media (min-width: 1200px) {

        .building-left,
        .building-right,
        .the-left-of-right-building {
            height: 100vh;
        }

        .building-right {
            bottom: -1rem;
        }

        .the-left-of-right-building {
            right: 2%;
        }

        .land-center {
            max-width: 200%;
        }

        .hero-content {
            padding-bottom: 8rem;
        }

        .cloud-bottom {
            bottom: -70vh;
            height: 150vh;
        }

    }
</style>

<section id="hero"
    class="relative w-screen h-screen flex flex-col justify-center items-center text-center text-black px-4">

    <!-- Background Buildings & Land -->
    <img src="{{ asset('assets/welcome-left-building.webp') }}" alt="Left Building" class="building-left">
    <img src="{{ asset('assets/welcome-full-Kincir.webp') }}" alt="Left Building" class="building-left">
    <img src="{{ asset('assets/welcome-land.webp') }}" alt="Land" class="land-center">
    <img src="{{ asset('assets/CLOUD-SEGARIS-02.webp') }}" alt="Cloud" class="cloud-bottom cloud-bottom-1">
    <img src="{{ asset('assets/welcome-pohon-pinggirnya.webp') }}" alt="Land" class="land-center"
        id="left-right-tree">
    <img src="{{ asset('assets/welcome-the-left-of-right-building.webp') }}" alt="Middle Right Building"
        class="the-left-of-right-building">
    <img src="{{ asset('assets/welcome-right-building.webp') }}" alt="Right Building" class="building-right">
    <img src="{{ asset('assets/PLANE-CUT.webp') }}" alt="Plane" class="plane">
    <img src="{{ asset('assets/welcome-awan.webp') }}" alt="cloud" class="cloud-bg">

    <!-- Hero Content -->
    <div class="hero-content">
        <h2 class="font-organetto text-2xl md:text-5xl font-bold text-white  drop-shadow-[0_0_15px_rgba(22,163,74,0.9)]"
            style="">
            OPEN RECRUITMENT
        </h2>
        <h1
            class="font-return-grid text-6xl md:text-7xl font-extrabol mt-1 sm:mt-3 md:mt-3 lg:mt-6 text-white drop-shadow-[0_0_15px_rgba(22,163,74,0.9)] tracking-wider">
            PETRA CIVIL EXPO
        </h1>
        <h2 class="font-return-grid text-3xl md:text-5xl font-extrabold -mt-5 md:-mt-10 text-white  drop-shadow-[0_0_15px_rgba(22,163,74,0.9)]"
            style="">2026</h2>
        {{-- <p class="font-organetto mt-4 text-lg
            md:text-xl font-medium text-green-600"
            style="text-shadow: 0 0 15px rgba(255,255,255,0.8);">
            Sustaining Growth, Building Futures
        </p> --}}
        <a href="{{ route('applicant.registerNow') }}" class="gradient-button gradient-button-shimmer mt-2">
            Register Here
        </a>
    </div>
</section>
