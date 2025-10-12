@extends('layout')
@section('head')
    <style>
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
            /* dari 1px diganti jadi 0px */
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
                confirmButtonColor: "#3085d6",
                icon: "error"
            });
        </script>
    @endif
    <div class="background flex flex-col w-screen h-full sm:min-h-screen items-center p-8 sm:p-14">
        <div class="flex flex-col w-full sm:w-9/12">
            <a href="{{ route('applicant.homepage') }}">
                <button
                    class="bg-pink-600 px-3 py-1 border-danger border-2 text-yellow-400 text-sm font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">
                    Back to Homepage
                </button>
            </a>
            <h1 class="font-squids text-shadow text-white text-4xl font-bold text-center my-8">{{ $title }}</h1>
            <div
                class="flex flex-col w-full border-4 bg-transparent bg-blur py-4 px-5 flex mx-auto block shadow-4 justify-center items-center">
                <form id="form_biodata" class="w-full" method="post" action="{{ route('applicant.biodata.store') }}">
                    @csrf
                    <div class="w-full mb-10">
                        <label for="nama_lengkap" class="font-organetto block mb-2 text-md font-medium text-yellow-400">Nama
                            Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap"
                            class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Nama Lengkap" required />
                    </div>

                    <div class="grid md:grid-cols-3 gap-6 mb-10">
                        <div class="w-full">
                            <label for="nrp"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">NRP</label>
                            <input type="text" id="nrp" name="nrp"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="NRP" required />
                        </div>
                        <div class="w-full">
                            <label for="angkatan"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">Angkatan</label>
                            <input type="number" id="angkatan" name="angkatan"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Angkatan" required />
                        </div>
                        <div class="w-full">
                            <label for="prodi"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">Program Studi</label>
                            <input type="text" id="prodi" name="prodi"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Program Studi" required />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6 mb-10">
                        <div class="w-full">
                            <label for="line_id" class="font-organetto block mb-2 text-md font-medium text-yellow-400">ID
                                Line</label>
                            <input type="text" id="line_id" name="line_id"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="ID Line" required />
                        </div>
                        <div class="w-full md:col-span-2">
                            <label for="no_hp"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">Nomor
                                WhatsApp</label>
                            <input type="text" id="no_hp" name="no_hp"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Nomor WhatsApp" required />
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 mb-10">
                        <div>
                            <label for="division_choice1"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">Divisi 1</label>
                            <select id="division_choice1" name="division_choice1"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option class="font-organetto-light bg-black" selected readonly hidden value="">Divisi
                                    1</option>
                                <option class="font-organetto-light bg-black" value="acara">Acara</option>
                                <option class="font-organetto-light bg-black" value="materi">Materi</option>
                                <option class="font-organetto-light bg-black" value="creative">Kreatif</option>
                                <option class="font-organetto-light bg-black" value="sponsor">Sponsorship</option>
                                <option class="font-organetto-light bg-black" value="sekkonkes">Sekkonkes</option>
                                <option class="font-organetto-light bg-black" value="transkapman">Transkapman</option>
                                <option class="font-organetto-light bg-black" value="it">IT</option>
                            </select>
                        </div>
                        <div>
                            <label for="division_choice2"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">Divisi 2</label>
                            <select id="division_choice2" name="division_choice2"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option class="font-organetto-light bg-black" selected readonly hidden value="">Divisi
                                    2</option>
                                <option class="font-organetto-light bg-black" value="">-</option>
                                <option class="font-organetto-light bg-black" value="acara">Acara</option>
                                <option class="font-organetto-light bg-black" value="materi">Materi</option>
                                <option class="font-organetto-light bg-black" value="creative">Kreatif</option>
                                <option class="font-organetto-light bg-black" value="sponsor">Sponsorship</option>
                                <option class="font-organetto-light bg-black" value="sekkonkes">Sekkonkes</option>
                                <option class="font-organetto-light bg-black" value="transkapman">Transkapman</option>
                                <option class="font-organetto-light bg-black" value="it">IT</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" id="submitBiodata"
                        class="bg-pink-600 w-full border-danger border-2 px-6 pb-2 pt-2.5 text-yellow-400 text-lg font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">Submit</button>
                </form>
                <button id="nextPage" onclick="window.location.href='{{ route('applicant.motivasi') }}'"
                    class="hidden bg-pink-600 w-full border-danger border-2 px-6 pb-2 pt-2.5 text-yellow-400 text-lg font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">Next
                    Page</button>
            </div>
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
            $(`#division_choice1 option[value=${dataMhs.division_choice1}]`).attr('selected', 'selected');
            document.getElementById('division_choice1').disabled = true;
            $(`#division_choice2 option[value=${dataMhs.division_choice2}]`).attr('selected', 'selected');
            document.getElementById('division_choice2').disabled = true;
            document.getElementById('submitBiodata').hidden = true;
            document.getElementById('nextPage').classList.remove('hidden');
        };


        $("#form_biodata").on('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Are you sure want to submit?",
                text: "Make sure the data is correct. Once you submit, the data cannot be changed!",
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
                                    const motivasiRoute =
                                        "{{ route('applicant.motivasi') }}"
                                    console.log(motivasiRoute);
                                    if (result.isConfirmed) {
                                        window.location.href = motivasiRoute;
                                    }
                                    setTimeout(() => {
                                        window.location.href = motivasiRoute;
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
