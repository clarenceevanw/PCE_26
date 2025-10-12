<style>
    .nav-unblur {
        backdrop-filter: blur(30px) brightness(0.85);
        -webkit-backdrop-filter: blur(30px) brightness(0.85);
        box-shadow: none;
        border-bottom: none;
    }

    @media screen and (max-width:1419px) {
        .nav-unblur {
            backdrop-filter: blur(13px) brightness(0.85);
            -webkit-backdrop-filter: blur(13px) brightness(0.85);
            box-shadow: none;
            border-bottom: none;
        }
    }
</style>
<!-- Main navigation container -->
<div class="relative z-50">
    <nav class="nav-unblur fixed top-0 left-0 right-0 flex w-full flex-nowrap items-center justify-between bg-transparent py-2 shadow-dark-mild xl:flex-wrap xl:justify-start xl:py-4"
        data-twe-navbar-ref>
        <div class="relative flex w-full flex-wrap items-center justify-between px-3">
            {{-- left logos --}}
            <div class="absolute left-4 flex flex-row">
                <img src="{{ asset('assets/PCU-LOGO.png') }}" alt="pcu Logo"
                    class="hidden xl:block h-[15px] 2xl:h-[25px] mr-3">
                <img src="{{ asset('assets/logo-ftsp-white.png') }}" alt="pcu Logo"
                    class="hidden xl:block h-[15px] 2xl:h-[25px] mr-3">
                <img src="{{ asset('assets/logo-fti-white.png') }}" alt="pcu Logo"
                    class="hidden xl:block h-[15px] 2xl:h-[25px] mr-3">
            </div>
            <!-- Hamburger button for mobile view -->
            <button
                class="block border-0 bg-transparent px-2 text-yellow-400/50 hover:no-underline hover:shadow-none focus:no-underline focus:shadow-none focus:outline-none focus:ring-0 dark:text-neutral-200 xl:hidden"
                type="button" data-twe-collapse-init data-twe-target="#navbarSupportedContent8"
                aria-controls="navbarSupportedContent8" aria-expanded="false" aria-label="Toggle navigation">
                <!-- Hamburger icon -->
                <span class="[&>svg]:w-7 [&>svg]:stroke-black/50 dark:[&>svg]:stroke-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z"
                            clip-rule="evenodd" />
                    </svg>
                </span>
            </button>

            <!-- Collapsible navbar container -->
            <div class="!visible mt-2 hidden flex-grow basis-[100%] items-center justify-center xl:mt-0 xl:!flex xl:basis-auto"
                id="navbarSupportedContent8" data-twe-collapse-item>
                <!-- Left links -->
                <ul class="list-style-none flex flex-col ps-0 xl:mt-1 xl:flex-row gap-x-3" data-twe-navbar-nav-ref>
                    <!-- Home link -->
                    <li class="my-4 ps-2 xl:my-0 xl:pe-1 xl:ps-2 xl:hover:scale-110 transition duration-100 hover:ease-in-out"
                        data-twe-nav-item-ref>
                        <a class="font-squids p-0 text-sm text-yellow-400 transition font-extrabold duration-200 hover:text-pink-600 hover:ease-in-out focus:text-yellow-400/80 active:text-yellow-400/80 xl:px-2"
                            href="#bombi" data-twe-nav-link-ref>HOME</a>
                    </li>

                    <li class="mb-4 ps-2 xl:mb-0 xl:pe-1 xl:ps-0 xl:hover:scale-110 transition duration-100 hover:ease-in-out"
                        data-twe-nav-item-ref>
                        <a class="font-squids p-0 text-sm text-yellow-400 transition font-extrabold duration-200 hover:text-pink-600 hover:ease-in-out focus:text-yellow-400/80 active:text-yellow-400/80 xl:px-2"
                            href="#penjelasan" data-twe-nav-link-ref>ABOUT</a>
                    </li>

                    <li class="mb-4 ps-2 xl:mb-0 xl:pe-1 xl:ps-0 xl:hover:scale-110 transition duration-100 hover:ease-in-out"
                        data-twe-nav-item-ref>
                        <a class="font-squids p-0 text-sm text-yellow-400 transition font-extrabold duration-200 hover:text-pink-600 hover:ease-in-out focus:text-yellow-400/80 active:text-yellow-400/80 xl:px-2"
                            href="#divisi" data-twe-nav-link-ref>DIVISIONS</a>
                    </li>

                    <li class="mb-4 ps-2 xl:mb-0 xl:pe-1 xl:ps-0 xl:hover:scale-110 transition duration-100 hover:ease-in-out"
                        data-twe-nav-item-ref>
                        <a class="font-squids p-0 text-sm text-yellow-400 transition font-extrabold duration-200 hover:text-pink-600 hover:ease-in-out focus:text-yellow-400/80 active:text-yellow-400/80 xl:px-2"
                            href="#requirement" data-twe-nav-link-ref>REQUIREMENTS</a>
                    </li>


                    <li class="mb-4 ps-2 xl:mb-0 xl:pe-1 xl:ps-0 xl:hover:scale-110 transition duration-100 hover:ease-in-out"
                        data-twe-nav-item-ref>
                        <a class="font-squids p-0 text-sm text-yellow-400 transition font-extrabold duration-200 hover:text-pink-600 hover:ease-in-out focus:text-yellow-400/80 active:text-yellow-400/80 xl:px-2"
                            href="#timeline" data-twe-nav-link-ref>TIMELINE</a>
                    </li>
                    <li class="mb-4 ps-2 xl:mb-0 xl:pe-1 xl:ps-0 xl:hover:scale-110 transition duration-100 hover:ease-in-out"
                        data-twe-nav-item-ref>
                        <a class="font-squids p-0 text-sm text-yellow-400 transition font-extrabold duration-200 hover:text-pink-600 hover:ease-in-out focus:text-yellow-400/80 active:text-yellow-400/80 xl:px-2"
                            href="#faq" data-twe-nav-link-ref>FAQ<span class="font-squids text-2xs">s</span></a>
                    </li>
                    <li class="mb-4 ps-2 xl:mb-0 xl:pe-1 xl:ps-0 xl:hover:scale-110 transition duration-100 hover:ease-in-out"
                        data-twe-nav-item-ref>
                        <a class="font-squids p-0 text-sm text-yellow-400 transition font-extrabold duration-200 hover:text-pink-600 hover:ease-in-out focus:text-yellow-400/80 active:text-yellow-400/80 xl:px-2"
                            href="#contact" data-twe-nav-link-ref>CONTACT US</a>
                    </li>
                    <li class="mb-4 ps-2 xl:mb-0 xl:pe-1 xl:ps-0 xl:hover:scale-110 transition duration-100 hover:ease-in-out"
                        data-twe-nav-item-ref>
                        @if (session('nrp'))
                            <a id="logout"
                                class="font-squids p-0 text-sm text-yellow-400 transition font-extrabold duration-200 hover:text-pink-600 hover:ease-in-out focus:text-yellow-400/80 active:text-yellow-400/80 xl:px-2"
                                href="{{ route('logout') }}" data-twe-nav-link-ref>LOG OUT</a>
                        @else
                            <a id="login"
                                class="font-squids p-0 text-sm text-yellow-400 transition font-extrabold duration-200 hover:text-pink-600 hover:ease-in-out focus:text-yellow-400/80 active:text-yellow-400/80 xl:px-2"
                                href="{{ route('applicant.login') }}" data-twe-nav-link-ref>LOG IN</a>
                        @endif
                    </li>
                </ul>
                <div class="absolute right-4 flex flex-row">
                    <img src="{{ asset('assets/logo-bom-white.png') }}" alt="pcu Logo"
                        class="hidden xl:block h-[40px] mr-3">
                </div>
            </div>
        </div>
    </nav>
</div>
