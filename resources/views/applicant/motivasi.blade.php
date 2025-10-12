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
            <a href="{{ route('applicant.biodata') }}">
                <button
                    class="bg-pink-600 w-[100px] border-danger py-1 border-2 text-yellow-400 text-sm font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">
                    Back
                </button>
            </a>
            </button>
            <h1 class="font-squids text-shadow text-white text-4xl font-bold text-center my-8">{{ $title }}</h1>
            <div
                class="flex flex-col w-full border-4 bg-transparent bg-blur py-4 px-5 flex mx-auto block shadow-4 justify-center items-center">
                <form id="form_motivasi" class="w-full" method="post" action="{{ route('applicant.motivasi.store') }}">
                    @csrf
                    <div class="grid md:grid-cols-2 md:gap-x-6">
                        <div class="relative z-0 w-full mb-5 group">
                            <label for="motivasi"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">Motivasi
                                Mendaftar</label>
                            <textarea id="motivasi" rows="2" name="motivasi"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 w-full p-2.5"
                                placeholder="Tuliskan motivasimu..."></textarea>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <label for="komitmen"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">Komitmen</label>
                            <textarea id="komitmen" rows="2" name="komitmen"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 w-full p-2.5"
                                placeholder="Tuliskan komitmenmu..."></textarea>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <label for="kelebihan"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">Kelebihan</label>
                            <textarea id="kelebihan" rows="2" name="kelebihan"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 w-full p-2.5"
                                placeholder="Tuliskan kelebihanmu..."></textarea>
                        </div>

                        <div class="relative z-0 w-full mb-5 group">
                            <label for="kekurangan"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">Kekurangan</label>
                            <textarea id="kekurangan" rows="2" name="kekurangan"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 w-full p-2.5"
                                placeholder="Tuliskan kekuranganmu..."></textarea>
                        </div>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <label for="pengalaman"
                            class="font-organetto block mb-2 text-md font-medium text-yellow-400">Pengalaman
                            Kepanitiaan</label>
                        <textarea id="pengalaman" rows="2" name="pengalaman"
                            class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 w-full p-2.5"
                            placeholder="Tuliskan pengalamanmu dalam berorganisasi/kepanitiaan..."></textarea>
                    </div>

                    <button type="submit" id="submitForm"
                        class="bg-pink-600 w-full border-danger border-2 px-6 pb-2 pt-2.5 text-yellow-400 text-lg font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">Submit</button>
                </form>
                <button id="nextPage" onclick="window.location.href='{{ route('applicant.berkas') }}'"
                    class="hidden bg-pink-600 w-full border-danger border-2 px-6 pb-2 pt-2.5 text-yellow-400 text-lg font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">Next
                    Page</button>

            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var dataMtv = JSON.parse(@json($data));
        console.log(dataMtv);

        if (JSON.parse(@json($isExists))) {
            document.getElementById('motivasi').value = dataMtv.motivasi;
            document.getElementById('motivasi').readOnly = true;
            document.getElementById('komitmen').value = dataMtv.komitmen;
            document.getElementById('komitmen').readOnly = true;
            document.getElementById('kelebihan').value = dataMtv.kelebihan;
            document.getElementById('kelebihan').readOnly = true;
            document.getElementById('kekurangan').value = dataMtv.kekurangan;
            document.getElementById('kekurangan').readOnly = true;
            document.getElementById('pengalaman').value = dataMtv.pengalaman;
            document.getElementById('pengalaman').readOnly = true;
            document.getElementById('submitForm').hidden = true;
            document.getElementById('nextPage').classList.remove('hidden');
        };
    </script>
    <script>
        $("#form_motivasi").on('submit', function(e) {
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
                                    const berkasRoute =
                                        "{{ route('applicant.berkas') }}"
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
