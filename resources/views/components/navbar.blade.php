<style>
    /* --- BASE STYLES --- */
    .nav-transparent {
        background: transparent;
        backdrop-filter: none;
        -webkit-backdrop-filter: none;
        transition: all 0.4s ease;
    }

    .nav-glass {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(15px) saturate(150%);
        -webkit-backdrop-filter: blur(15px) saturate(150%);
        transition: all 0.4s ease;
    }

    .nav-hidden {
        transform: translateY(-100%);
        transition: transform 0.4s ease;
    }

    /* --- DESKTOP --- */
    .nav-desktop-item a {
        position: relative;
        font-weight: 600;
        color: rgb(22, 163, 74);
        /* background-shadow: 0px 0px 15px rgba(22,163,74,0.9); */
        transition: color 0.3s ease;
    }

    .nav-desktop-item a::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -3px;
        width: 0%;
        height: 2px;
        background: rgb(255, 255, 255);
        transition: width 0.3s ease;
    }

    .nav-desktop-item a:hover::after {
        width: 100%;
    }

    /* --- MOBILE --- */
    .nav-mobile-menu {
        position: fixed;
        top: 0;
        right: 0;
        width: 100%;
        height: 100vh;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(18px) saturate(180%);
        -webkit-backdrop-filter: blur(18px) saturate(180%);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        transform: translateY(-100%);
        opacity: 0;
        transition: all 0.4s ease;
        z-index: 40;
    }

    .nav-mobile-menu.show {
        transform: translateY(0);
        opacity: 1;
    }

    .nav-mobile-btn {
        z-index: 50;
        transition: transform 0.4s ease;
    }

    .nav-mobile-btn.active span:nth-child(1) {
        transform: rotate(45deg) translateY(8px);
    }

    .nav-mobile-btn.active span:nth-child(2) {
        opacity: 0;
    }

    .nav-mobile-btn.active span:nth-child(3) {
        transform: rotate(-45deg) translateY(-8px);
    }

    .nav-mobile-btn span {
        display: block;
        width: 25px;
        height: 2px;
        background: #000;
        margin: 2px 0;
        transition: all 0.4s ease;
    }

    @media screen and (orientation: portrait) {
        .nav-desktop {
            display: none;
        }

        .nav-mobile {
            display: flex;
        }

        .logo-desktop {
            display: none;
        }
    }

    @media screen and (orientation: landscape) {
        .nav-desktop {
            display: flex;
        }

        .nav-mobile {
            display: none;
        }

        .logo-desktop {
            display: flex;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navbar = document.getElementById("navbar");
        const mobileMenu = document.getElementById("mobileMenu");
        const menuBtn = document.getElementById("menuBtn");
        let lastScrollTop = 0;

        // Scroll effect
        window.addEventListener("scroll", function() {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;

            if (currentScroll > 50) {
                navbar.classList.remove("nav-transparent");
                navbar.classList.add("nav-glass");
            } else {
                navbar.classList.remove("nav-glass");
                navbar.classList.add("nav-transparent");
            }

            if (currentScroll > lastScrollTop && currentScroll > 100) {
                navbar.classList.add("nav-hidden");
            } else {
                navbar.classList.remove("nav-hidden");
            }

            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        });

        // Mobile menu toggle
        menuBtn.addEventListener("click", () => {
            menuBtn.classList.toggle("active");
            mobileMenu.classList.toggle("show");
        });

        // Tutup menu saat klik link
        document.querySelectorAll("#mobileMenu a").forEach(link => {
            link.addEventListener("click", () => {
                mobileMenu.classList.remove("show");
                menuBtn.classList.remove("active");
            });
        });
    });
</script>

<!-- 🌐 Navbar -->
<div id="navbar"
    class="nav-transparent fixed top-0 left-0 right-0 z-50 flex w-full items-center justify-between py-4 px-4 transition duration-500">

    <!-- Logo (Desktop Only) -->
    <div class="logo-desktop items-center space-x-3 hidden">
        <img src="{{ asset('assets/logo-PCE-new.png') }}" alt="Logo PCE" class="h-[32px] w-auto object-contain">
    </div>

    <!-- Desktop Navbar -->
    <div class="nav-desktop hidden">
        <ul class="flex flex-row gap-x-8 items-center">
            @php
                $navItems = [
                    ['text' => 'About Us', 'href' => '#about'],
                    ['text' => 'Divisions', 'href' => '#divisi'],
                    ['text' => 'Requirements', 'href' => '#requirement'],
                    ['text' => 'Timeline', 'href' => '#timeline'],
                    ['text' => 'Contact', 'href' => '#contact'],
                ];
            @endphp

            @foreach ($navItems as $item)
                <li class="nav-desktop-item font-organetto ">
                    <a href="{{ $item['href'] }}" class="text-base">{{ $item['text'] }}</a>
                </li>
            @endforeach
            @if (session()->has('email'))
                <li class="nav-desktop-item">
                    <a href="{{ route('logout') }}" class="text-base">Logout</a>
                </li>
            @else
                <li class="nav-desktop-item font-organetto ">
                    <a href="{{ route('applicant.login') }}" class="text-base">Login</a>
                </li>
            @endif
        </ul>
    </div>

    <!-- Mobile Navbar -->
    <div class="nav-mobile hidden items-center">
        <button id="menuBtn"
            class="nav-mobile-btn flex flex-col justify-center items-center border-0 bg-transparent p-2">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <!-- Mobile Fullscreen Menu -->
    <div id="mobileMenu" class="nav-mobile-menu">
        <img src="{{ asset('assets/logo-PCE-new.png') }}" alt="Logo PCE" class="h-[2.5rem] mb-4">
        @foreach ($navItems as $item)
            <a href="{{ $item['href'] }}" class="text-black font-semibold text-lg">{{ $item['text'] }}</a>
        @endforeach
        @if (session()->has('email'))
            <a href="{{ route('logout') }}" class="text-black font-semibold text-lg font-organetto ">Logout</a>
        @else
            <a href="{{ route('applicant.login') }}" class="text-black font-semibold text-lg font-organetto ">Login</a>
        @endif
    </div>
</div>
