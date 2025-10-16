@extends('layout')
@section('head')
@endsection
@section('content')
    @if (session()->has('error'))
        <script>
            Swal.fire({
                title: "ERROR",
                text: "{{ session('error') }}",
                confirmButtonColor: "#a855f7",
                icon: "error"
            });
        </script>
    @endif

    <div class="background min-h-screen w-full flex flex-col items-center justify-center px-4 py-6 sm:px-6 lg:px-8">
        <div class="w-full max-w-4xl">
            <!-- Back Button -->
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
                {{ Str::upper($title); }}
            </h1>

            <!-- Main Container -->
            <div
                class="bg-purple-950/40 backdrop-blur-sm rounded-2xl p-6 sm:p-8 border-2 border-purple-500/50 transition-all duration-500">
                <!-- Title -->
                

                <div id="form_container" class="w-full">
                    <form id="form_berkas" class="w-full space-y-6" method="post"
                        action="{{ route('applicant.berkas.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Upload Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Upload Berkas -->
                            <div class="space-y-3">
                                <label class="font-organetto block text-sm sm:text-base font-bold text-white uppercase tracking-widest"
                                    for="berkas">
                                    Upload Berkas 
                                </label>
                                <a href="https://docs.google.com/document/d/1TB_fgZlNFKLE7fHP20Uqo7gwTF3IiDjAC8Foj2beyDw/edit?usp=sharing"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 text-purple-300 hover:text-purple-100 transition-colors duration-300 text-xs sm:text-sm font-organetto underline decoration-purple-400 underline-offset-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Lihat Contoh Template
                                </a>
                                <!-- Custom File Upload -->
                                <div class="relative group">
                                    <input class="hidden" id="berkas" name="berkas" type="file" accept=".pdf"
                                        onchange="updateFileName(this)">
                                    <label for="berkas" id="berkasLabel"
                                        class="flex items-center justify-center gap-3 w-full px-4 py-3 bg-transparent border-2 border-purple-500/50 rounded-full text-white font-organetto text-xs sm:text-sm cursor-pointer transition-all duration-300 hover:border-purple-400 hover:shadow-[0_0_12px_rgba(168,85,247,0.4)] hover:bg-purple-900/20">
                                        <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span id="file-name" class="text-purple-200 text-sm">Pilih file PDF</span>
                                    </label>
                                </div>
                                <p class="text-purple-300/60 text-[11px] sm:text-xs font-organetto-light">
                                    Format: PDF | Max: 10MB
                                </p>
                            </div>

                            <!-- Portofolio -->
                            <div class="space-y-3">
                                <label for="portofolio"
                                    class="font-organetto block text-sm sm:text-base font-bold text-white uppercase tracking-widest">
                                    Portofolio <span class="text-purple-400 text-xs font-normal">(Divisi Kreatif)</span>
                                </label>
                                <p class="text-purple-300/60 text-[11px] sm:text-xs font-organetto-light -mt-1">
                                    Link Google Drive, Behance, atau portfolio online Anda
                                </p>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-5 flex items-center pointer-events-none">
                                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                    </div>
                                    <input type="text" id="portofolio" name="portofolio"
                                        placeholder="https://drive.google.com/..."
                                        class="w-full pl-12 pr-4 py-3 bg-transparent border-2 border-purple-500/50 rounded-full text-white font-organetto-light text-sm sm:text-base placeholder-purple-300/40 transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)] hover:border-purple-400/70" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit" id="submitForm"
                                class="w-full px-6 py-3 bg-transparent border-2 border-purple-500 text-white text-base sm:text-lg font-bold uppercase tracking-widest rounded-full transition-all duration-300 hover:bg-white hover:text-purple-500 hover:shadow-[0_0_25px_rgba(168,85,247,0.6)] hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                                Submit Berkas
                            </button>
                        </div>
                    </form>

                    <!-- Next Page Button -->
                    <button id="nextPage" onclick="window.location.href='{{ route('applicant.jadwal') }}'"
                        class="hidden w-full px-6 py-3 bg-transparent border-2 border-purple-500 text-white text-base sm:text-lg font-bold uppercase tracking-widest rounded-full transition-all duration-300 hover:bg-white hover:text-purple-500 hover:shadow-[0_0_25px_rgba(168,85,247,0.6)] hover:scale-[1.02] active:scale-[0.98] mt-4">
                        Next Page →
                    </button>
                </div>
            </div>

            <p
                class="text-center text-white text-xs sm:text-sm mt-6 font-organetto tracking-wide">
                Pastikan file yang diupload sesuai dengan format yang ditentukan
            </p>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function updateFileName(input) {
            const fileName = input.files[0]?.name || 'Pilih file PDF';
            const fileNameSpan = document.getElementById('file-name');
            const label = input.nextElementSibling;
            
            if (input.files[0]) {
                fileNameSpan.textContent = fileName;
                label.classList.add('border-purple-400', 'bg-purple-900/30');
                label.classList.remove('border-purple-500/50');
            } else {
                fileNameSpan.textContent = 'Pilih file PDF';
                label.classList.remove('border-purple-400', 'bg-purple-900/30');
                label.classList.add('border-purple-500/50');
            }
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const data = @json($data);
            const isExists = @json($isExists);

            if (isExists) {
                const berkasInput = document.getElementById('berkas');
                const berkasLabel = document.getElementById('berkasLabel');
                const portofolioInput = document.getElementById('portofolio');
                const submitBtn = document.getElementById('submitForm');
                const nextBtn = document.getElementById('nextPage');

                if (berkasInput) berkasInput.classList.add("hidden");
                if (berkasLabel) berkasLabel.classList.add("hidden");

                if (portofolioInput) {
                    portofolioInput.disabled = true;
                    portofolioInput.readOnly = true;
                    portofolioInput.value = data['portofolio'] ?? "-";
                }

                if (submitBtn) submitBtn.hidden = true;
                if (nextBtn) nextBtn.classList.remove('hidden');

                if (berkasInput) {
                    const container = berkasInput.parentNode;
                    const fileName = data['berkas']
                        ? data['berkas'].split('/').pop()
                        : "Tidak ada file";

                    const fileDisplay = document.createElement('div');
                    fileDisplay.className = `
                        mt-3 text-purple-200 text-sm sm:text-base font-organetto-light 
                        bg-purple-900/20 border border-purple-500/50 rounded-full 
                        px-5 py-3 text-center select-none
                    `;

                    if (data['berkas']) {
                        const fileLink = document.createElement('a');
                        fileLink.href = `${data['berkas']}`;
                        fileLink.target = "_blank";
                        fileLink.innerText = fileName;
                        fileLink.className = `
                            hover:text-purple-300 underline underline-offset-4
                            transition-colors duration-300
                        `;
                        fileDisplay.appendChild(fileLink);
                    } else {
                        fileDisplay.innerText = "Tidak ada file";
                    }
                    container.appendChild(fileDisplay);
                }
            }
        });
    </script>
    <script>
        $("#form_berkas").on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Are you sure want to submit?",
                text: "Once you submit, the data cannot be changed!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, submit it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $(this)[0];
                    var formData = new FormData(form);
                    var method = $(this).attr('method');
                    var url = $(this).attr('action');
                    if (document.getElementById('portofolio').value === null) {
                        formData.append(document.getElementById('portofolio').name, null);
                    }

                    // var loader = document.querySelector(".data-loader");
                    // loader.classList.remove("hidden");
                    // loader.classList.add("flex");
                    $.ajax({
                        type: method,
                        url: url,
                        data: formData,
                        processData: false, //to prevent jQuery from automatically transforming the data into a query string
                        contentType: false,
                        cache: false,
                        success: async function(response) {
                            // loader.classList.add("hidden");
                            // loader.classList.remove("flex");
                            if (response.success) {
                                await Swal.fire({
                                    title: "Success!",
                                    text: response.message,
                                    icon: "success",
                                    confirmButtonColor: "#3085d6",
                                    confirmButtonText: "OK"
                                }).then((result) => {
                                    const jadwalRoute =
                                        "{{ route('applicant.jadwal') }}"
                                    if (result.isConfirmed) {
                                        window.location.href = jadwalRoute;
                                    }
                                    setTimeout(() => {
                                        window.location.href = jadwalRoute;
                                    }, 1500);

                                });
                            } else {
                                await Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    html: response.message,
                                    confirmButtonColor: "#3085d6"
                                });
                            }
                        },
                        error: async function(xhr, textStatus, errorThrown) {
                            // loader.classList.add("hidden");
                            // loader.classList.remove("flex");
                            await Swal.fire({
                                title: 'Oops!',
                                text: 'Something went wrong: ' + textStatus + '-' +
                                    errorThrown,
                                icon: 'error',
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                } else {
                    // User canceled the submission
                    Swal.fire({
                        title: "Cancelled!",
                        text: "Your data was not submitted.",
                        icon: "info",
                        confirmButtonColor: "#3085d6",
                        confirmButtonText: "OK"
                    });
                }
            });
        })
    </script>
@endsection
