<section
    id="about"
    class="w-screen min-h-screen relative overflow-hidden flex items-center justify-center px-6 py-20"
>
    <div
        class="absolute top-0 left-0 w-[25rem] h-[25rem] rounded-full mix-blend-multiply filter blur-3xl opacity-10 bg-blue-500 animate-pulse"
    ></div>
    <div
        class="absolute bottom-0 right-0 w-[25rem] h-[25rem] rounded-full mix-blend-multiply filter blur-3xl opacity-10 bg-indigo-500 animate-pulse"
        style="animation-delay: 2s;"
    ></div>

    <div id="aboutContent" class="relative text-center max-w-4xl mx-auto opacity-0 scale-90">
        <h1
            class="font-return-grid text-5xl sm:text-6xl lg:text-7xl font-bold mb-8 bg-gradient-to-r from-blue-400 via-indigo-300 to-blue-300 bg-clip-text text-transparent leading-tight"
        >
            PETRA CIVIL EXPO 2026
        </h1>

        <div id="aboutText" class="font-organetto space-y-6 text-gray-300 text-lg md:text-xl leading-relaxed mb-4">
            <p>
                <span class="font-semibold text-blue-300">Petra Civil Expo</span> is the biggest annual competition
                held by the Civil Engineering Department of Petra Christian University.
            </p>
            <p>
                Serving as a platform for innovation and collaboration among future engineers, PCE brings together
                talented students from across Indonesia to showcase their skills, creativity, and technical knowledge.
            </p>
            <p class="font-semibold text-blue-300 text-lg md:text-xl">
                This event features three main competitions:
            </p>
        </div>

        <div class="font-organetto flex flex-wrap justify-center gap-4 mt-6 text-[0.8rem]">
            <div
                class="badge px-6 py-3 bg-gradient-to-r from-blue-600/40 to-indigo-600/40 border border-blue-400/50 rounded-lg backdrop-blur-sm hover:from-blue-600/60 hover:to-indigo-600/60 transition-all duration-300 opacity-0 translate-y-8"
            >
                <span class="text-blue-200 font-semibold">Bridge Competition</span>
            </div>
            <div
                class="badge px-6 py-3 bg-gradient-to-r from-blue-600/40 to-indigo-600/40 border border-blue-400/50 rounded-lg backdrop-blur-sm hover:from-blue-600/60 hover:to-indigo-600/60 transition-all duration-300 opacity-0 translate-y-8"
            >
                <span class="text-blue-200 font-semibold">Concrete Strength Competition</span>
            </div>
            <div
                class="badge px-6 py-3 bg-gradient-to-r from-blue-600/40 to-indigo-600/40 border border-blue-400/50 rounded-lg backdrop-blur-sm hover:from-blue-600/60 hover:to-indigo-600/60 transition-all duration-300 opacity-0 translate-y-8"
            >
                <span class="text-blue-200 font-semibold">Earthquake Resistance Design Competition</span>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        gsap.registerPlugin(ScrollTrigger);

        const aboutContent = document.getElementById("aboutContent");
        const badges = document.querySelectorAll(".badge");
        const paragraphs = document.querySelectorAll("#aboutText p");

        // Section entrance (zoom + fade)
        gsap.to(aboutContent, {
            scrollTrigger: {
                trigger: aboutContent,
                start: "top 80%",
            },
            opacity: 1,
            scale: 1,
            duration: 1.4,
            ease: "power3.out",
        });

        // Create overlay
        paragraphs.forEach((p, i) => {
            const wrapper = document.createElement("span");
            wrapper.style.position = "relative";
            wrapper.style.display = "inline-block";
            wrapper.innerHTML = p.innerHTML;
            p.innerHTML = "";
            p.appendChild(wrapper);

            const overlay = document.createElement("span");
            overlay.className = "absolute bottom-0 left-0 bg-blue-500 rounded-sm";
            overlay.style.height = "100%";
            overlay.style.width = "100%";
            overlay.style.transformOrigin = i % 2 === 0 ? "right" : "right";
            overlay.style.transform = "scaleX(1)";
            overlay.style.zIndex = "5";
            wrapper.appendChild(overlay);

            gsap.fromTo(
                p,
                { opacity: 0, y: 40 },
                {
                    opacity: 1,
                    y: 0,
                    duration: 1.2,
                    ease: "power3.out",
                    delay: i * 0.2,
                    scrollTrigger: {
                        trigger: p,
                        start: "top 85%",
                    },
                    onStart: () => {
                        gsap.to(overlay, {
                            scaleX: 0,
                            duration: 1.2,
                            ease: "power2.out",
                        });
                    },
                }
            );
        });

        // Animate badges
        gsap.to(badges, {
            scrollTrigger: {
                trigger: aboutContent,
                start: "top 80%",
            },
            opacity: 1,
            y: 0,
            stagger: 0.25,
            duration: 1.2,
            ease: "power3.out",
            delay: 0.5,
        });
    });
</script>