<style>
    body {
        overflow-x: hidden;
    }

    #hero {
        position: relative;
        overflow: hidden;
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
        z-index: 3;
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

    .hero-content {
        position: relative;
        z-index: 10;
        padding-bottom: 10rem;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .the-left-of-right-building {
            right: 2%;
        }

        .building-right {
            bottom: -0.5rem;
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
            padding-bottom: 8rem;
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
    }
</style>

<section id="hero"
    class="relative w-screen h-screen flex flex-col justify-center items-center text-center text-black px-4">

    <!-- Background Buildings & Land -->
    <img src="{{ asset('assets/welcome-left-building.png') }}" alt="Left Building" class="building-left">
    <img src="{{ asset('assets/welcome-land.png') }}" alt="Land" class="land-center">
    <img src="{{ asset('assets/welcome-the-left-of-right-building.png') }}" alt="Middle Right Building"
        class="the-left-of-right-building">
    <img src="{{ asset('assets/welcome-right-building.png') }}" alt="Right Building" class="building-right">

    <!-- Hero Content -->
    <div class="hero-content">
        <h2 class="font-organetto text-2xl md:text-3xl font-bold">OPEN RECRUITMENT</h2>
        <h1 class="font-return-grid text-4xl md:text-6xl font-extrabold mt-2">
            PETRA CIVIL EXPO
        </h1>
        <h2 class="font-return-grid text-3xl md:text-5xl font-extrabold mt-1">2026</h2>
        <p class="font-organetto mt-4 text-lg md:text-xl font-medium">
            Sustaining Growth, Building Futures
        </p>
        <a href="{{ route('applicant.biodata') }}"
            class="font-organetto mt-10 text-lg md:text-xl relative inline-block px-6 py-2 font-semibold text-black border-2 border-[#7EC8D6] rounded-full 
             bg-[#7EC8D6] transition-all duration-300 
             hover:bg-transparent hover:text-[#7EC8D6]
             before:content-[''] before:absolute before:inset-[-8px] before:rounded-full before:border-2 before:border-[#7EC8D6] 
             before:opacity-70 before:transition-all before:duration-300 before:scale-100 
             hover:before:opacity-100 hover:before:scale-110">
            Register Here
        </a>
    </div>
</section>
