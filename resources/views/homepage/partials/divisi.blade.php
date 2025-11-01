<style>
    #divisi {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        width: 100%;
        color: #333;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    h1 {
        color: white;
        text-align: center;
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 50px;
        text-shadow: 6px 4px 15px rgba(255, 255, 255, 0.3);
    }

    .swiper {
        width: 75%;
        max-width: 1200px;
        padding: 50px 0;
        /* overflow: hidden; */
        overflow: visible;
    }

    .swiper-wrapper {
        align-items: center;
    }

    .swiper-slide {
        width: 280px;
        aspect-ratio: 3/4;
        perspective: 1000px;
        transition: opacity 0.3s ease;
    }

    .swiper-slide-active {
        opacity: 1;
    }

    .swiper-slide-next,
    .swiper-slide-prev {
        opacity: 0.8;
    }

    .swiper-slide {
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .swiper-slide {
            width: 200px;
        }
    }

    .card-container {
        position: relative;
        width: 100%;
        height: 100%;
        transition: transform 0.6s;
        transform-style: preserve-3d;
        cursor: pointer;
    }

    .card-container.flipped {
        transform: rotateY(180deg);
    }

    .card-face {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .card-front {
        background: linear-gradient(135deg, #4d845a 0%, #9ad640a8 60%);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #ddd;
    }

    .card-front img {
        width: 80%;
        height: 80%;
        object-fit: contain;
    }

    .card-back {
        background: linear-gradient(135deg, #3f5542 0%, #4d845a 100%);
        transform: rotateY(180deg);
        display: flex;
        flex-direction: column;
        padding: 30px 20px;
        color: white;
        border: 2px solid #ffd620;
    }

    .card-back h3 {
        font-size: 1.5rem;
        color: #ffd620;
        margin-bottom: 20px;
        text-transform: uppercase;
        text-align: center;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .card-back p {
        font-size: 0.95rem;
        line-height: 1.6;
        text-align: center;
        flex: 1;
        display: flex;
        align-items: center;
    }

    .title {
        position: absolute;
        bottom: -60px;
        left: 50%;
        transform: translateX(-50%);
        width: max-content;
        margin-top: 0;
        text-align: center;
        padding: 10px 20px;
        background: #333;
        border-radius: 8px;
        border: 2px solid #333;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
        z-index: 10;
    }

    .swiper-slide-active .title {
        bottom: -60px !important;
    }

    .title span {
        color: #ffd620;
        font-size: 1rem;
        font-weight: 600;
    }

    .swiper-slide-active .title {
        bottom: -20px;
        box-shadow: 0 20px 30px 2px rgba(0, 0, 0, 0.2);
    }

    .flip-hint {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 214, 32, 0.9);
        color: #333;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: bold;
        z-index: 5;
    }

    @media (max-width: 1024px) {
        .swiper-slide {
            width: 220px;
        }

        .card-back h3 {
            font-size: 1.2rem;
        }

        .card-back p {
            font-size: 0.8rem;
        }

        h1 {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .swiper {
            width: 95%;
        }

        .swiper-slide {
            width: 180px;
        }

        .card-back {
            padding: 20px 15px;
        }

        .card-back h3 {
            font-size: 1rem;
            margin-bottom: 12px;
        }

        .card-back p {
            font-size: 0.7rem;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .title span {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 480px) {
        .swiper-slide {
            width: 160px;
        }

        h1 {
            font-size: 1.5rem;
        }

        .card-back h3 {
            font-size: 0.9rem;
        }

        .card-back p {
            font-size: 0.65rem;
        }

        .title span {
            font-size: 0.75rem;
        }

        .flip-hint {
            font-size: 0.6rem;
            padding: 4px 8px;
        }
    }
</style>

<section id="divisi">
    {{-- <h1 class="font-return-grid text-4xl sm:text-5xl lg:text-6xl font-bold bg-gradient-to-r from-green-600 via-green-500 to-green-500 bg-clip-text text-transparent mb-12 leading-tight"
        data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-out-cubic">
        Divisi
    </h1> --}}

    <h1 class="font-return-grid text-4xl sm:text-5xl lg:text-6xl font-bold bg-gradient-to-r text-white drop-shadow-[0_0_15px_rgba(22,163,74,0.9)] tracking-wider bg-clip-text  mb-12 leading-tight"
        data-aos="fade-down" data-aos-duration="800" data-aos-easing="ease-out-cubic">
        DIVISION
    </h1>

    <div class="swiper">
        <div class="swiper-wrapper">
            <!-- Sponsor -->
            <div class="swiper-slide">
                <div class="card-container">
                    <div class="card-face card-front">
                        <img src="{{ asset('assets/logo sponsor.webp') }}" alt="Sponsor">
                        <div class="flip-hint">Click to flip</div>
                    </div>
                    <div class="card-face card-back">
                        <h3>Sponsor</h3>
                        <p>Divisi yang menjalin kerjasama dengan berbagai pihak guna mendapatkan dukungan dana demi
                            keberlangsungan acara.</p>
                    </div>
                </div>
                <div class="title"><span>Sponsor</span></div>
            </div>

            <!-- Transkapman -->
            <div class="swiper-slide">
                <div class="card-container">
                    <div class="card-face card-front">
                        <img src="{{ asset('assets/logo transkapman.webp') }}" alt="Transkapman">
                        <div class="flip-hint">Click to flip</div>
                    </div>
                    <div class="card-face card-back">
                        <h3>Transkapman</h3>
                        <p>Divisi yang bertanggung jawab atas transportasi, perlengkapan, dan keamanan acara.</p>
                    </div>
                </div>
                <div class="title"><span>Transkapman</span></div>
            </div>

            <!-- Acara -->
            <div class="swiper-slide">
                <div class="card-container">
                    <div class="card-face card-front">
                        <img src="{{ asset('assets/logo acara.webp') }}" alt="Acara">
                        <div class="flip-hint">Click to flip</div>
                    </div>
                    <div class="card-face card-back">
                        <h3>Acara</h3>
                        <p>Divisi yang mengkonsep, merencanakan, hingga mengeksekusi acara di hari-H kegiatan.</p>
                    </div>
                </div>
                <div class="title"><span>Acara</span></div>
            </div>

            <!-- Creative -->
            <div class="swiper-slide">
                <div class="card-container">
                    <div class="card-face card-front">
                        <img src="{{ asset('assets/logo creative.webp') }}" alt="Creative">
                        <div class="flip-hint">Click to flip</div>
                    </div>
                    <div class="card-face card-back">
                        <h3>Creative</h3>
                        <p>Divisi yang bertugas untuk membuat video, poster, animasi, dan berbagai aset lainnya yang
                            mendukung kelancaran acara.</p>
                    </div>
                </div>
                <div class="title"><span>Creative</span></div>
            </div>

            <!-- IT -->
            <div class="swiper-slide">
                <div class="card-container">
                    <div class="card-face card-front">
                        <img src="{{ asset('assets/logo IT.webp') }}" alt="IT">
                        <div class="flip-hint">Click to flip</div>
                    </div>
                    <div class="card-face card-back">
                        <h3>IT</h3>
                        <p>Divisi yang bertugas untuk membuat website Petra Civil Expo.</p>
                    </div>
                </div>
                <div class="title"><span>IT</span></div>
            </div>

            <!-- Sekkonkes -->
            <div class="swiper-slide">
                <div class="card-container">
                    <div class="card-face card-front">
                        <img src="{{ asset('assets/logo sekkonkes.webp') }}" alt="sekkon">
                        <div class="flip-hint">Click to flip</div>
                    </div>
                    <div class="card-face card-back">
                        <h3>Sekkonkes</h3>
                        <p>Divisi yang bertanggung jawab atas data panitia dan peserta. Mereka juga memastikan kesehatan
                            dan ketersediaan konsumsi bagi panitia dan peserta ketika hari-H kegiatan.</p>
                    </div>
                </div>
                <div class="title"><span>Sekkonkes</span></div>
            </div>

            {{-- pr --}}
            <div class="swiper-slide">
                <div class="card-container">
                    <div class="card-face card-front">
                        <img src="{{ asset('assets/logo PR.webp') }}" alt="pr">
                        <div class="flip-hint">Click to flip</div>
                    </div>
                    <div class="card-face card-back">
                        <h3>Public Relation</h3>
                        <p> Divisi yang bertugas untuk menjalin hubungan dengan pihak eksternal hingga mempromosikan PCE
                            2026 di berbagai platform.</p>
                    </div>
                </div>
                <div class="title"><span>Public Relation</span></div>
            </div>
        </div>
    </div>
</section>
