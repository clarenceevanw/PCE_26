<section
    id="requirement"
    class="relative w-screen min-h-screen flex items-center justify-center overflow-hidden bg-transparent"
>
    <div class="relative z-10 flex flex-col items-center justify-center w-11/12 sm:w-9/12 text-center">
        <h1
            id="reqTitle"
            class="font-return-grid text-5xl sm:text-6xl lg:text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-blue-500 mb-14 opacity-0 drop-shadow-[0_0_15px_rgba(147,197,253,0.5)]"
        >
            REQUIREMENTS
        </h1>

        <div
            id="reqBox"
            class="relative border border-blue-400/30 bg-white/10 backdrop-blur-md rounded-2xl p-10 shadow-[0_0_40px_rgba(59,130,246,0.15)] opacity-0 overflow-hidden"
            style="height: 0;"
        >
            <div
                class="absolute inset-0 rounded-2xl p-[2px] -z-10"
            ></div>

            <ul id="reqList" class="space-y-4 font-organetto text-white text-lg md:text-xl font-organetto text-left opacity-0">
                <li>- PCU Students Batch '23 and '24 <span class="text-blue-300">(FTI & FTSP prioritized)</span></li>
                <li>- GPA ≥ 2.75</li>
                <li>- Screenshot of Transcript & SKKK</li>
                <li>- Student ID Card (KTM)</li>
                <li>- Course Schedule</li>
                <li>- Portfolio <span class="text-indigo-300">(Creative Division only)</span></li>
            </ul>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.registerPlugin(ScrollTrigger);

        const reqTitle = document.getElementById("reqTitle");
        const reqBox = document.getElementById("reqBox");
        const reqList = document.getElementById("reqList");
        const reqItems = reqList.querySelectorAll("li");

        // Title fade-down
        gsap.to(reqTitle, {
            scrollTrigger: {
                trigger: reqTitle,
                start: "top 80%",
            },
            opacity: 1,
            y: 0,
            duration: 1.2,
            ease: "power3.out",
        });

        // Card expand
        gsap.to(reqBox, {
            scrollTrigger: {
                trigger: reqBox,
                start: "top 85%",
            },
            height: "auto",
            opacity: 1,
            duration: 1.4,
            ease: "power3.inOut",
            delay: 0.3,
            onComplete: () => {
                // Fade in list after card expansion
                gsap.to(reqList, {
                    opacity: 1,
                    duration: 0.8,
                    ease: "power2.out",
                });

                // Each list item stagger reveal
                gsap.from(reqItems, {
                    y: 30,
                    opacity: 0,
                    stagger: 0.2,
                    duration: 0.8,
                    ease: "power2.out",
                });
            },
        });
    });
</script>