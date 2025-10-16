@extends('layout')
@section('head')
@endsection
@section('content')
    <div class="background min-h-screen w-full flex flex-col items-center justify-center px-4 py-6 sm:px-6 lg:px-8">
        <div class="w-full max-w-4xl">
            <div class="mb-6 sm:mb-8">
                <a href="{{ route('applicant.biodata') }}">
                    <button
                        class="px-6 py-2 border-2 border-purple-500 text-white text-sm sm:text-base font-bold uppercase tracking-widest rounded-full transition-all duration-300 hover:bg-white hover:text-purple-500 hover:shadow-lg hover:shadow-purple-500/50 hover:scale-105 active:scale-95">
                        ← Back
                    </button>
                </a>
            </div>

            <h1
                class="font-return-grid text-white text-2xl sm:text-4xl font-bold text-center mb-8 tracking-wider drop-shadow-[0_0_25px_rgba(168,85,247,0.9)]">
                {{ Str::upper($title) }}
            </h1>

            <div class="bg-purple-950/40 backdrop-blur-sm rounded-2xl p-6 sm:p-8 border-2 border-purple-500/50 space-y-10">

                @php
                    $inputs = [
                        ['id' => 'ktm', 'label' => 'KTM', 'type' => 'file', 'route' => route('applicant.berkas.ktm.store')],
                        ['id' => 'skkk', 'label' => 'SKKK', 'type' => 'file', 'route' => route('applicant.berkas.skkk.store')],
                        ['id' => 'bukti_kecurangan', 'label' => 'Bukti Kecurangan', 'type' => 'file', 'route' => route('applicant.berkas.bukti_kecurangan.store')],
                        ['id' => 'transkrip', 'label' => 'Transkrip Nilai', 'type' => 'file', 'route' => route('applicant.berkas.transkrip.store')],
                        ['id' => 'portofolio', 'label' => 'Portofolio (Divisi Kreatif)', 'type' => 'text', 'route' => route('applicant.berkas.portofolio.store')],
                    ];
                @endphp

                @foreach ($inputs as $input)
                    {{-- Definisikan variabel untuk data yang ada agar mudah dibaca --}}
                    @php
                        $existingData = $data[$input['id']] ?? null;
                    @endphp

                    <form class="flex flex-col sm:flex-row items-center gap-4 single-upload-form" method="post"
                        enctype="multipart/form-data" action="{{ $input['route'] }}">
                        @csrf

                        <div class="flex-1 w-full">
                            <label for="{{ $input['id'] }}"
                                class="font-organetto block text-sm sm:text-base font-bold text-white uppercase tracking-widest mb-2">
                                {{ $input['label'] }}
                            </label>

                            {{-- JIKA DATA SUDAH ADA --}}
                            @if (!empty($existingData))
                                <div class="w-full flex gap-4">
                                    
                                    {{-- Tambahkan kondisi ini untuk membedakan tampilan --}}
                                    @if ($input['type'] === 'file')
                                        {{-- Tampilan untuk FILE yang sudah diunggah --}}
                                        <a href="{{ $existingData }}" target="_blank" rel="noopener noreferrer"
                                            class="flex items-center justify-center gap-3 w-full px-4 py-3 bg-purple-900/30 border-2 border-green-500/50 rounded-full text-white font-organetto text-xs sm:text-sm cursor-pointer transition-all duration-300 hover:border-green-400 hover:shadow-[0_0_12px_rgba(74,222,128,0.4)]">
                                            <svg class="w-5 h-5 text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-green-200 text-sm">Lihat Berkas Terunggah</span>
                                        </a>
                                    @else
                                        {{-- Tampilan untuk TEXT (Portofolio) yang sudah diisi --}}
                                        <input type="text" value="{{ $existingData }}" disabled
                                            class="w-full pl-4 pr-4 py-3 bg-purple-900/30 border-2 border-green-500/50 rounded-full text-green-200 font-organetto-light text-sm sm:text-base cursor-not-allowed" />
                                    @endif

                                    {{-- Tombol submit yang dinonaktifkan (berlaku untuk keduanya) --}}
                                    <button type="button" disabled
                                        class="px-5 py-2.5 bg-gray-700/50 border-2 border-gray-600 text-gray-400 font-bold rounded-full cursor-not-allowed">
                                        Submitted
                                    </button>
                                </div>
                                <p class="text-green-400/60 text-[11px] sm:text-xs mt-1 font-organetto-light">
                                    Data telah berhasil disubmit.
                                </p>
                            @else
                                {{-- JIKA DATA BELUM ADA (KODE ORIGINAL ANDA) --}}
                                @if ($input['type'] === 'file')
                                    <div class="w-full flex gap-4">
                                        <div class="relative group w-full">
                                            <input class="hidden" id="{{ $input['id'] }}" name="{{ $input['id'] }}"
                                                type="file" accept=".pdf" onchange="updateFileName(this)">
                                            <label for="{{ $input['id'] }}" id="{{ $input['id'] }}Label"
                                                class="flex items-center justify-center gap-3 w-full px-4 py-3 bg-transparent border-2 border-purple-500/50 rounded-full text-white font-organetto text-xs sm:text-sm cursor-pointer transition-all duration-300 hover:border-purple-400 hover:shadow-[0_0_12px_rgba(168,85,247,0.4)] hover:bg-purple-900/20">
                                                <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <span class="file-name text-purple-200 text-sm">Pilih file PDF</span>
                                            </label>
                                        </div>
                                        <button type="submit"
                                            class="px-5 py-2.5 bg-transparent border-2 border-purple-500 text-white font-bold rounded-full transition-all duration-300 hover:bg-white hover:text-purple-500 hover:shadow-[0_0_25px_rgba(168,85,247,0.6)] active:scale-[0.97]">
                                            Upload
                                        </button>
                                    </div>
                                    <p class="text-purple-300/60 text-[11px] sm:text-xs mt-1 font-organetto-light">
                                        Format: PDF | Max: 10MB
                                    </p>
                                @else
                                    <div class="w-full flex gap-4">
                                        <input type="text" id="{{ $input['id'] }}" name="{{ $input['id'] }}"
                                            placeholder="https://drive.google.com/..."
                                            class="w-full pl-4 pr-4 py-3 bg-transparent border-2 border-purple-500/50 rounded-full text-white font-organetto-light text-sm sm:text-base placeholder-purple-300/40 transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)] hover:border-purple-400/70" />
                                        <button type="submit"
                                            class="px-5 py-2.5 bg-transparent border-2 border-purple-500 text-white font-bold rounded-full transition-all duration-300 hover:bg-white hover:text-purple-500 hover:shadow-[0_0_25px_rgba(168,85,247,0.6)] active:scale-[0.97]">
                                            Submit
                                        </button>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </form>
                @endforeach

                <div class="pt-4">
                    <button id="nextPage"
                        class="w-full px-6 py-3 bg-transparent border-2 border-purple-500 text-white text-base sm:text-lg font-bold uppercase tracking-widest rounded-full transition-all duration-300 hover:bg-white hover:text-purple-500 hover:shadow-[0_0_25px_rgba(168,85,247,0.6)] hover:scale-[1.02] active:scale-[0.98]">
                        Next Page →
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    function updateFileName(input) {
        const fileName = input.files[0]?.name || 'Pilih file PDF';
        input.parentElement.querySelector('.file-name').textContent = fileName;
    }

    $('#nextPage').on('click', function () {
        $.ajax({
            url: "{{ route('applicant.check-berkas') }}",
            method: "GET",
            success: function (response) {
                if (response.success) {
                    window.location.href = "{{ route('applicant.jadwal') }}";
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        html: response.message,
                        confirmButtonColor: "#a855f7"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        })
    });

    // Handle submit setiap form individual
    $('.single-upload-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this)[0];
        const formData = new FormData(form);
        const url = $(this).attr('action');

        Swal.fire({
            title: "Submit berkas ini?",
            text: "Pastikan file atau link sudah benar.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#a855f7",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, submit!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: async function (response) {
                        if (response.success) {
                            await Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: response.message,
                                confirmButtonColor: "#a855f7"
                            });
                            location.reload();
                        } else {
                            await Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                html: response.message,
                                confirmButtonColor: "#a855f7"
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Terjadi kesalahan!",
                            text: xhr.statusText,
                            confirmButtonColor: "#a855f7"
                        });
                    }
                });
            }
        });
    });
</script>
@endsection
