<style>
    .contact-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(100px);
        opacity: 0.2;
        animation: orbFloat 25s infinite ease-in-out;
    }

    .orb-1 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, #60a5fa, #3b82f6);
        top: -10%;
        left: -10%;
        animation-delay: 0s;
    }

    .orb-2 {
        width: 350px;
        height: 350px;
        background: linear-gradient(135deg, #a78bfa, #8b5cf6);
        bottom: -10%;
        right: -10%;
        animation-delay: 8s;
    }

    .orb-3 {
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, #ec4899, #d946ef);
        top: 50%;
        left: 50%;
        animation-delay: 16s;
    }

    @keyframes orbFloat {

        0%,
        100% {
            transform: translate(0, 0) scale(1);
        }

        25% {
            transform: translate(50px, -50px) scale(1.1);
        }

        50% {
            transform: translate(-30px, 30px) scale(0.9);
        }

        75% {
            transform: translate(40px, 40px) scale(1.05);
        }
    }

    @keyframes ping-slow {
        0% {
            transform: scale(1);
            opacity: 0.2;
        }

        50% {
            transform: scale(1.5);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 0.2;
        }
    }

    @keyframes ping-slower {
        0% {
            transform: scale(1);
            opacity: 0.15;
        }

        50% {
            transform: scale(2);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 0.15;
        }
    }

    .animate-ping-slow {
        animation: ping-slow 4s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    .animate-ping-slower {
        animation: ping-slower 6s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    /* Social link hover */
    .social-link {
        position: relative;
    }

    /* Responsive adjustments */
    @media (max-width: 1024px) {
        .contact-orb {
            filter: blur(70px);
        }
    }

    @media (max-width: 768px) {
        .contact-orb {
            filter: blur(60px);
        }

        .orb-1,
        .orb-2,
        .orb-3 {
            width: 250px;
            height: 250px;
        }
    }
</style>

<section id="contact" class="relative flex w-screen min-h-screen py-20 overflow-hidden">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="contact-orb orb-1"></div>
        <div class="contact-orb orb-2"></div>
        <div class="contact-orb orb-3"></div>
    </div>

    <div class="absolute inset-0 opacity-10"
        style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 50px 50px;"></div>

    <div class="relative z-10 flex flex-col w-full justify-center items-center px-4 md:px-8">
        <div class="w-full max-w-7xl" data-aos="zoom-in" data-aos-duration="1000">
            <div
                class="relative bg-white/90 backdrop-blur-xl border-2 border-white/30 rounded-3xl p-8 md:p-12 lg:p-16 shadow-2xl hover:shadow-[0_0_60px_rgba(255,255,255,0.3)] transition-all duration-500">

                <div class="relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                    <div class="flex flex-col items-center justify-center space-y-8">
                        <!-- Main PCU Logo -->
                        <div class="relative group" data-aos="fade-right" data-aos-duration="800" data-aos-delay="200">
                            <div
                                class="absolute -inset-4 bg-gradient-to-r from-blue-400 to-indigo-400 rounded-full blur-2xl opacity-20 group-hover:opacity-40 transition-opacity duration-500">
                            </div>
                            <img src="{{ asset('assets/PCU - LOGO - 4.png') }}"
                                class="relative w-48 md:w-64 lg:w-72 drop-shadow-2xl transform group-hover:scale-105 transition-transform duration-500"
                                alt="PCU Logo">
                        </div>

                        <div class="flex flex-col sm:flex-row items-center gap-6 w-full justify-center">
                            <div class="relative group" data-aos="fade-right" data-aos-duration="800"
                                data-aos-delay="400">
                                <div
                                    class="absolute -inset-2 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-xl blur-lg opacity-10 group-hover:opacity-30 transition-opacity duration-500">
                                </div>
                                <img src="{{ asset('assets/LOGO-SIPIL FINAL-04.png') }}"
                                    class="relative w-40 md:w-48 lg:w-56 transform group-hover:scale-105 transition-transform duration-500 drop-shadow-lg"
                                    alt="SIPIL LOGO">
                            </div>

                            <div class="relative group" data-aos="fade-right" data-aos-duration="800"
                                data-aos-delay="600">
                                <div
                                    class="absolute -inset-2 bg-gradient-to-r from-indigo-400 to-purple-400 rounded-xl blur-lg opacity-10 group-hover:opacity-30 transition-opacity duration-500">
                                </div>
                                <img src="{{ asset('assets/Logo-HIMASITRA.png') }}"
                                    class="relative w-28 md:w-32 lg:w-36 transform group-hover:scale-105 transition-transform duration-500 drop-shadow-lg"
                                    alt="Logo HIMASITRA">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center justify-center" data-aos="fade-left" data-aos-duration="800"
                        data-aos-delay="400">
                        <div class="text-center mb-8">
                            <h2
                                class="font-organetto text-3xl md:text-4xl lg:text-5xl font-bold mb-3 bg-gradient-to-r from-green-600 via-green-600 to-green-800 bg-clip-text text-transparent">
                                Get In Touch
                            </h2>
                            <p class="font-organetto text-gray-600 text-sm md:text-base lg:text-lg">
                                Have questions? We're here to help!
                            </p>
                        </div>

                        <div class="flex justify-center items-center gap-8 mb-10">
                            <!-- LINE -->
                            <a href="https://line.me/R/ti/p/@958jigfh" target="_blank"
                                class="social-link group relative" data-aos="zoom-in" data-aos-duration="600"
                                data-aos-delay="600">
                                <div
                                    class="absolute -inset-2 bg-gradient-to-br from-green-400 to-green-500 rounded-2xl blur-lg opacity-0 group-hover:opacity-70 transition-all duration-500">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-green-400 to-green-500 p-5 rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-110 hover:-rotate-6 transition-all duration-500">
                                    <img src="{{ asset('assets/line-messenger-logo-svgrepo-com.png') }}" alt="LINE"
                                        class="w-12 h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 drop-shadow-lg">
                                </div>
                                <span
                                    class="absolute -bottom-10 left-1/2 transform -translate-x-1/2 font-organetto text-sm text-gray-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-semibold">
                                    Chat on LINE
                                </span>
                            </a>

                            <a href="https://www.instagram.com/pce.pcu/" target="_blank"
                                class="social-link group relative" data-aos="zoom-in" data-aos-duration="600"
                                data-aos-delay="800">
                                <div
                                    class="absolute -inset-2 bg-gradient-to-br from-pink-400 via-purple-400 to-indigo-500 rounded-2xl blur-lg opacity-0 group-hover:opacity-70 transition-all duration-500">
                                </div>
                                <div
                                    class="relative bg-gradient-to-br from-pink-400 via-purple-400 to-indigo-500 p-5 rounded-2xl shadow-xl hover:shadow-2xl transform hover:scale-110 hover:rotate-6 transition-all duration-500">
                                    <img src="{{ asset('assets/instagram-1-svgrepo-com.png') }}" alt="Instagram"
                                        class="w-12 h-12 md:w-14 md:h-14 lg:w-16 lg:h-16 drop-shadow-lg">
                                </div>
                                <span
                                    class="absolute -bottom-10 left-1/2 transform -translate-x-1/2 font-organetto text-sm text-gray-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-semibold">
                                    Follow us
                                </span>
                            </a>
                        </div>

                        <div class="pt-8 border-t border-gray-300 w-full max-w-md">
                            <p class="font-organetto text-center text-gray-600 text-sm md:text-base">
                                <span class="font-bold text-gray-800 text-base md:text-lg">Petra Civil Expo
                                    2026</span><br>
                                <span class="text-green-600 font-semibold">The Biggest Civil Competition in
                                    Indonesia</span>
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Decorative elements -->
        <div
            class="absolute bottom-10 left-10 w-32 h-32 border-4 border-white/20 rounded-full animate-ping-slow hidden lg:block">
        </div>
        <div
            class="absolute top-20 right-20 w-24 h-24 border-4 border-white/20 rounded-full animate-ping-slower hidden lg:block">
        </div>
    </div>
</section>
