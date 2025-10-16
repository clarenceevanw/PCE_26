@extends('layout')
@section('head')
    <style>
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
        [multiple]:focus,
        [type=date]:focus,
        [type=datetime-local]:focus,
        [type=email]:focus,
        [type=month]:focus,
        [type=number]:focus,
        [type=password]:focus,
        [type=search]:focus,
        [type=tel]:focus,
        [type=text]:focus,
        [type=time]:focus,
        [type=url]:focus,
        [type=week]:focus,
        select:focus,
        textarea:focus {
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(0px + var(--tw-ring-offset-width)) var(--tw-ring-color);
        }
    </style>
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

    <div class="background min-h-screen flex flex-col items-center justify-center px-4 py-6 sm:px-6 lg:px-8">
        <div class="w-full max-w-5xl">
            <!-- Back Button -->
            <div class="mb-6 sm:mb-8 text-left">
                <a href="{{ route('applicant.homepage') }}">
                    <button
                        class="px-6 py-2 border-2 border-purple-500 text-white font-bold uppercase tracking-widest rounded-full text-sm sm:text-base transition-all duration-300 hover:bg-white hover:text-purple-500 hover:shadow-lg hover:shadow-purple-500/40">
                        ← Back
                    </button>
                </a>
            </div>

            <!-- Title -->
            <h1
                class="font-return-grid text-white text-2xl sm:text-4xl font-bold text-center mb-8 sm:mb-10 tracking-wider drop-shadow-[0_0_25px_rgba(168,85,247,0.8)]">
                {{ Str::upper($title); }}
            </h1>

            <!-- Form Container -->
            <div
                class="neon-border bg-purple-950/40 backdrop-blur-sm rounded-2xl p-5 sm:p-8 border border-purple-500/40 transition-all duration-500 neon-glow">
                <form id="form_biodata" method="post" action="{{ route('applicant.biodata.store') }}" class="space-y-6">
                    @csrf
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama_lengkap"
                            class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">
                            Nama Lengkap
                        </label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-2.5 bg-transparent border border-purple-500/50 rounded-full text-white text-sm sm:text-base placeholder-purple-300/40 transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]" />
                    </div>

                    <!-- Grid NRP, Angkatan, Prodi -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="nrp"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">NRP</label>
                            <input type="text" id="nrp" name="nrp" placeholder="NRP"
                                class="w-full px-4 py-2.5 bg-transparent border border-purple-500/50 rounded-full text-white text-sm sm:text-base placeholder-purple-300/40 transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]"
                                required />
                        </div>
                        <div>
                            <label for="angkatan"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">Angkatan</label>
                            <input type="number" id="angkatan" name="angkatan" placeholder="2024"
                                class="w-full px-4 py-2.5 bg-transparent border border-purple-500/50 rounded-full text-white text-sm sm:text-base placeholder-purple-300/40 transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]"
                                required />
                        </div>
                        <div>
                            <label for="prodi"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">Prodi</label>
                            <input type="text" id="prodi" name="prodi" placeholder="Informatika"
                                class="w-full px-4 py-2.5 bg-transparent border border-purple-500/50 rounded-full text-white text-sm sm:text-base placeholder-purple-300/40 transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]"
                                required />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="line_id"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">ID Line</label>
                            <input type="text" id="line_id" name="line_id" placeholder="ID Line"
                                class="w-full px-4 py-2.5 bg-transparent border border-purple-500/50 rounded-full text-white text-sm sm:text-base placeholder-purple-300/40 transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]"
                                required />
                        </div>
                        <div>
                            <label for="no_hp"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">Whatsapp Number</label>
                            <input type="number" id="no_hp" name="no_hp" placeholder="Co: +6281234567890 / 081234567890"
                                class="w-full px-4 py-2.5 bg-transparent border border-purple-500/50 rounded-full text-white text-sm sm:text-base placeholder-purple-300/40 transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]"
                                required />
                        </div>
                    </div>

                    <!-- Textarea Section -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="motivasi"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">
                                Motivasi Bergabung
                            </label>
                            <textarea id="motivasi" name="motivasi" rows="3"
                                placeholder="Apa yang memotivasi Anda untuk bergabung?"
                                class="w-full px-4 py-3 bg-transparent border border-purple-500/50 rounded-2xl text-white text-sm sm:text-base placeholder-purple-300/40 resize-none transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]"></textarea>
                        </div>

                        <div>
                            <label for="komitmen"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">
                                Komitmen
                            </label>
                            <textarea id="komitmen" name="komitmen" rows="3"
                                placeholder="Bagaimana komitmen Anda jika diterima?"
                                class="w-full px-4 py-3 bg-transparent border border-purple-500/50 rounded-2xl text-white text-sm sm:text-base placeholder-purple-300/40 resize-none transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]"></textarea>
                        </div>

                        <div>
                            <label for="kelebihan"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">
                                Kelebihan
                            </label>
                            <textarea id="kelebihan" name="kelebihan" rows="3"
                                placeholder="Tuliskan kelebihan Anda"
                                class="w-full px-4 py-3 bg-transparent border border-purple-500/50 rounded-2xl text-white text-sm sm:text-base placeholder-purple-300/40 resize-none transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]"></textarea>
                        </div>

                        <div>
                            <label for="kekurangan"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">
                                Kekurangan
                            </label>
                            <textarea id="kekurangan" name="kekurangan" rows="3"
                                placeholder="Tuliskan kekurangan Anda"
                                class="w-full px-4 py-3 bg-transparent border border-purple-500/50 rounded-2xl text-white text-sm sm:text-base placeholder-purple-300/40 resize-none transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]"></textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="pengalaman"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">
                                Pengalaman Organisasi / Kepanitiaan
                            </label>
                            <textarea id="pengalaman" name="pengalaman" rows="3"
                                placeholder="Ceritakan pengalaman Anda dalam organisasi atau kepanitiaan sebelumnya"
                                class="w-full px-4 py-3 bg-transparent border border-purple-500/50 rounded-2xl text-white text-sm sm:text-base placeholder-purple-300/40 resize-none transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]"></textarea>
                        </div>
                    </div>

                    <!-- Divisi Selection -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="division_choice1"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">
                                Divisi 1
                            </label>
                            <select id="division_choice1" name="division_choice1"
                                class="w-full px-4 py-2.5 bg-transparent border border-purple-500/50 rounded-full text-white text-sm sm:text-base appearance-none cursor-pointer transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]">
                                <option class="bg-purple-950 text-purple-200" disabled selected hidden>Pilih Divisi Pertama</option>
                                <option class="bg-purple-950" value="acara">Acara</option>
                                <option class="bg-purple-950" value="materi">Materi</option>
                                <option class="bg-purple-950" value="creative">Kreatif</option>
                                <option class="bg-purple-950" value="sponsor">Sponsorship</option>
                                <option class="bg-purple-950" value="sekkonkes">Sekkonkes</option>
                                <option class="bg-purple-950" value="transkapman">Transkapman</option>
                                <option class="bg-purple-950" value="it">IT</option>
                            </select>
                        </div>
                        <div>
                            <label for="division_choice2"
                                class="font-organetto block mb-2 text-sm sm:text-base font-semibold text-white uppercase tracking-wider">
                                Divisi 2
                            </label>
                            <select id="division_choice2" name="division_choice2"
                                class="w-full px-4 py-2.5 bg-transparent border border-purple-500/50 rounded-full text-white text-sm sm:text-base appearance-none cursor-pointer transition-all duration-300 focus:outline-none focus:border-purple-400 focus:shadow-[0_0_12px_rgba(168,85,247,0.4)]">
                                <option class="bg-purple-950 text-purple-200" disabled selected hidden>Pilih Divisi Kedua</option>
                                <option class="bg-purple-950" value="acara">Acara</option>
                                <option class="bg-purple-950" value="materi">Materi</option>
                                <option class="bg-purple-950" value="creative">Kreatif</option>
                                <option class="bg-purple-950" value="sponsor">Sponsorship</option>
                                <option class="bg-purple-950" value="sekkonkes">Sekkonkes</option>
                                <option class="bg-purple-950" value="transkapman">Transkapman</option>
                                <option class="bg-purple-950" value="it">IT</option>
                            </select>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" id="submitBiodata"
                            class="w-full px-6 py-3 border-2 border-purple-500 text-white text-base sm:text-lg font-bold uppercase tracking-widest rounded-full transition-all duration-300 hover:bg-white hover:text-purple-500">
                            Submit
                        </button>
                        <button type="button" id="nextPage" class="w-full px-6 py-3 border-2 border-purple-500 text-white text-base sm:text-lg font-bold uppercase tracking-widest rounded-full transition-all duration-300 hover:bg-white hover:text-purple-500 hidden">Next Page</button>
                    </div>
                </form>
            </div>

            <!-- Info Text -->
            <p class="text-center text-white text-xs sm:text-sm mt-6 font-organetto tracking-wide">
                Pastikan semua data yang dimasukkan sudah benar sebelum submit
            </p>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var dataMhs = JSON.parse(@json($dataMhs));
        document.getElementById('nama_lengkap').value = dataMhs.name;
        document.getElementById('nama_lengkap').readOnly = true;
        document.getElementById('nrp').value = dataMhs.nrp;
        document.getElementById('nrp').readOnly = true;
        document.getElementById('angkatan').value = dataMhs.angkatan;
        document.getElementById('angkatan').readOnly = true;

        if (JSON.parse(@json($exists))) {
            document.getElementById('nama_lengkap').disabled = true;
            document.getElementById('nrp').disabled = true;
            document.getElementById('angkatan').disabled = true;
            document.getElementById('prodi').value = dataMhs.prodi;
            document.getElementById('prodi').disabled = true;
            document.getElementById('line_id').value = dataMhs.line_id;
            document.getElementById('line_id').disabled = true;
            document.getElementById('no_hp').value = dataMhs.no_hp;
            document.getElementById('no_hp').disabled = true;
            document.getElementById('motivasi').value = dataMhs.motivasi;
            document.getElementById('motivasi').readOnly = true;
            document.getElementById('kelebihan').value = dataMhs.kelebihan;
            document.getElementById('kelebihan').readOnly = true;
            document.getElementById('kekurangan').value = dataMhs.kekurangan;
            document.getElementById('kekurangan').readOnly = true;
            document.getElementById('komitmen').value = dataMhs.komitmen;
            document.getElementById('komitmen').readOnly = true;
            document.getElementById('pengalaman').value = dataMhs.pengalaman;
            document.getElementById('pengalaman').readOnly = true;
            $(`#division_choice1 option[value=${dataMhs.division_choice1}]`).attr('selected', 'selected');
            document.getElementById('division_choice1').disabled = true;
            $(`#division_choice2 option[value=${dataMhs.division_choice2}]`).attr('selected', 'selected');
            document.getElementById('division_choice2').disabled = true;
            document.getElementById('submitBiodata').hidden = true;
            document.getElementById('nextPage').classList.remove('hidden');
        };

        $("#nextPage").on('click', function() {
            window.location.href = "{{ route('applicant.berkas') }}";
        });

        $("#form_biodata").on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Konfirmasi Submit",
                text: "Pastikan data sudah benar. Setelah submit, data tidak dapat diubah!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#a855f7",
                cancelButtonColor: "#e11d48",
                confirmButtonText: "Ya, Submit!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    var form = $(this)[0];
                    var formData = new FormData(form);
                    var method = $(this).attr('method');
                    var url = $(this).attr('action');

                    $.ajax({
                        type: method,
                        url: url,
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: async function(response) {
                            if (response.success) {
                                await Swal.fire({
                                    title: "Berhasil!",
                                    text: response.message,
                                    icon: "success",
                                    confirmButtonColor: "rgba(168, 85, 247, 1)",
                                    confirmButtonText: "OK"
                                }).then((result) => {
                                    const berkasRoute = "{{ route('applicant.berkas') }}"
                                    if (result.isConfirmed) {
                                        window.location.href = berkasRoute;
                                    }
                                    setTimeout(() => {
                                        window.location.href = berkasRoute;
                                    }, 1500);
                                });
                            } else {
                                await Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    html: response.message,
                                    confirmButtonColor: "#a855f7"
                                });
                            }
                        },
                        error: async function(xhr, textStatus, errorThrown) {
                            await Swal.fire({
                                title: 'Oops!',
                                text: 'Something went wrong: ' + textStatus + '-' + errorThrown,
                                icon: 'error',
                                confirmButtonColor: "#a855f7",
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                } else {
                    Swal.fire({
                        title: "Dibatalkan!",
                        text: "Data tidak disubmit.",
                        icon: "info",
                        confirmButtonColor: "#a855f7",
                        confirmButtonText: "OK"
                    });
                }
            });
        })
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const numberInputs = document.querySelectorAll('input[type="number"]');
            numberInputs.forEach(input => {
                
                input.addEventListener('focus', () => {
                input.addEventListener('wheel', preventWheelChange);
                });

                input.addEventListener('blur', () => {
                input.removeEventListener('wheel', preventWheelChange);
                });

            });

            function preventWheelChange(event) {
                event.preventDefault();
            }
        });
    </script>
@endsection