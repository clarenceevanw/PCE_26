<style>
    /* Animated background particles */
    .particle {
        position: absolute;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.15;
        animation: float 20s infinite ease-in-out;
    }

    .particle-1 {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .particle-2 {
        background: linear-gradient(135deg, #60a5fa, #3b82f6);
        top: 50%;
        right: 10%;
        animation-delay: 7s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translate(0, 0) scale(1);
        }

        33% {
            transform: translate(30px, -30px) scale(1.1);
        }

        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
    }

    /* Timeline line animation */
    .timeline-line {
        animation: lineGrow 1.5s ease-out forwards;
    }

    @keyframes lineGrow {
        from {
            transform: translateX(-50%) scaleY(0);
            transform-origin: top;
        }

        to {
            transform: translateX(-50%) scaleY(1);
            transform-origin: top;
        }
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .particle {
            width: 200px;
            height: 200px;
            filter: blur(60px);
        }

        #timeline .space-y-16 {
            gap: 2rem;
        }

        /* Hide the central timeline line on mobile */
        .timeline-line {
            /* display: none ; */
        }

        /* Change grid to single column centered layout */
        #timeline .relative.grid {
            grid-template-columns: 1fr !important;
            gap: 0 !important;
            display: flex !important;
            justify-content: center !important;
        }

        /* Hide empty spacer divs */
        #timeline .relative.grid>div:empty {
            display: none !important;
        }

        /* Center the content boxes */
        #timeline .relative.grid>div {
            width: 100% !important;
            display: flex !important;
            justify-content: center !important;
        }

        #timeline .bg-white\/90 {
            max-width: 100% !important;
            width: 100% !important;
            padding: 1.25rem;
        }

        #timeline h3 {
            font-size: 1.125rem;
        }

        #timeline .w-12.h-12 {
            width: 2.5rem;
            height: 2.5rem;
        }

        #timeline .w-12.h-12 svg {
            width: 1.25rem;
            height: 1.25rem;
        }
    }

    @media (max-width: 480px) {
        .timeline-line {
            left: 1.5rem !important;
        }

        .max-w-sm {
            margin-left: 2.5rem !important;
            padding: 1rem !important;
        }

        h3 {
            font-size: 1rem !important;
        }

        .text-sm {
            font-size: 0.75rem !important;
        }

        .text-base {
            font-size: 0.875rem !important;
        }

        .w-12 {
            width: 2.5rem !important;
            height: 2.5rem !important;
        }

        .w-6 {
            width: 1.25rem !important;
            height: 1.25rem !important;
        }
    }

    @media (max-width: 480px) {
        #timeline {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        #timeline .bg-white\/90 {
            padding: 1rem;
        }

        #timeline h3 {
            font-size: 1rem;
        }

        #timeline .text-sm {
            font-size: 0.75rem;
        }

        #timeline .text-base {
            font-size: 0.875rem;
        }
    }
</style>
<section id="timeline" class="relative flex w-screen min-h-screen py-20 overflow-hidden">
    <!-- Animated background particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
    </div>

    <div class="relative z-10 flex flex-col w-full justify-center items-center px-4">

        <h1 class="font-return-grid text-4xl sm:text-5xl lg:text-6xl font-bold bg-gradient-to-r text-white drop-shadow-[0_0_15px_rgba(22,163,74,0.9)] tracking-wider bg-clip-text  mb-12 leading-tight"
            data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-out-cubic">
            TIMELINE
        </h1>
        <!-- Timeline Container -->
        <div class="relative w-full max-w-4xl">
            <!-- Central Line -->
            <div
                class="absolute left-1/2 top-0 bottom-0 w-1 bg-gradient-to-b from-green-400 via-green-400 to-green-600 transform -translate-x-1/2 timeline-line">
            </div>

            <!-- Timeline Items -->
            <div class="space-y-16">
                <!-- Item 1 - Open Recruitment (Left) -->
                <div class="relative grid grid-cols-2 gap-4 items-center" data-aos="fade-right" data-aos-duration="800"
                    data-aos-delay="200">
                    <div class="flex justify-end">
                        <div
                            class="bg-white/90 backdrop-blur-md border-2 border-green-400/70 rounded-2xl p-6 shadow-2xl hover:shadow-[0_0_40px_rgba(251,191,36,0.5)] transition-all duration-500 hover:scale-105 w-full max-w-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-organetto font-bold text-xl text-gray-800">Open Recruitment</h3>
                                    <p class="font-organetto text-sm text-gray-600">Registration Phase</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-green-600 font-organetto font-semibold">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-base">22 Oktober - 3 November 2025</span>
                            </div>
                        </div>
                    </div>
                    <div></div>
                </div>

                <!-- Item 2 - Interview (Right) -->
                <div class="relative grid grid-cols-2 gap-4 items-center" data-aos="fade-left" data-aos-duration="800"
                    data-aos-delay="400">
                    <div></div>
                    <div class="flex justify-start">
                        <div
                            class="bg-white/90 backdrop-blur-md border-2 border-green-700/70 rounded-2xl p-6 shadow-2xl hover:shadow-[0_0_40px_rgba(96,165,250,0.5)] transition-all duration-500 hover:scale-105 w-full max-w-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-500 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-organetto font-bold text-xl text-gray-800">Interview</h3>
                                    <p class="font-organetto text-sm text-gray-600">Selection Process</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 text-green-600 font-organetto font-semibold">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-base"> 23 Oktober - 4 November 2025</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
