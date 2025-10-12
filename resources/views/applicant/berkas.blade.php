@extends('layout')
@section('head')
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
    <div class="background flex flex-col w-screen h-screen sm:min-h-screen items-center p-8 sm:p-14">
        <div class="flex flex-col w-full sm:w-9/12">
            <a href="{{ route('applicant.motivasi') }}">
                <button
                    class="bg-pink-600 w-[100px] py-1 border-danger border-2 text-yellow-400 text-sm font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">
                    Back
                </button>
            </a>
            <h1 class="font-squids text-shadow text-white text-4xl font-bold text-center my-8">{{ $title }}</h1>
            <div id="form_container"
                class="flex flex-col w-full border-4 bg-transparent bg-blur py-4 px-5 flex mx-auto block shadow-4 justify-center items-center">
                <form id="form_berkas" class="w-full" method="post" action="{{ route('applicant.berkas.store') }}">
                    @csrf
                    <div class="flex w-full grid md:grid-cols-2 gap-6 mb-16">
                        <div>
                            <label class="font-organetto block mb-2 text-md font-medium text-yellow-400"
                                for="berkas">Upload Berkas <a href="https://docs.google.com/document/d/1TB_fgZlNFKLE7fHP20Uqo7gwTF3IiDjAC8Foj2beyDw/edit?usp=sharing" target="_blank" class="underline text-white">(Contoh Template)</a></label>
                            <input
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full"
                                id="berkas" name="berkas" type="file" accept=".pdf">
                        </div>
                        <div class="flex flex-col w-full">
                            <label for="portofolio"
                                class="font-organetto block mb-2 text-md font-medium text-yellow-400">Portofolio (divisi
                                kreatif)</label>
                            <input type="text" id="portofolio" name="portofolio"
                                class="border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Link portofolio..." />
                        </div>
                    </div>
                    <div class="flex w-full justify-center items-center">
                        <button type="submit" id="submitForm"
                            class="bg-pink-600 w-full border-danger border-2 px-6 pb-2 pt-2.5 text-yellow-400 text-lg font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">Submit</button>
                    </div>
                </form>
                <button id="nextPage" onclick="window.location.href='{{ route('applicant.jadwal') }}'"
                    class="hidden bg-pink-600 w-full border-danger border-2 px-6 pb-2 pt-2.5 text-yellow-400 text-lg font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">Next
                    Page</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const data = JSON.parse(@json($data));
        if (JSON.parse(@json($isExists))) {
            // document.getElementById('foto_diri').disabled = true;
            document.getElementById('berkas').disabled = true;
            // document.getElementById('cv').disabled = true;
            // document.getElementById('transkrip').disabled = true;
            // document.getElementById('skkk').disabled = true;
            // document.getElementById('bukti_kecurangan').disabled = true;
            // document.getElementById('jadwal').disabled = true;
            document.getElementById('submitForm').hidden = true;
            document.getElementById('nextPage').classList.remove('hidden');
            const fileData = {
                // foto_diri: data['foto_diri'] ?? null,
                berkas: data['berkas'] ?? null,
                // cv: data['cv'] ?? null,
                // transkrip: data['transkrip'] ?? null,
                // skkk: data['skkk'] ?? null,
                // bukti_kecurangan: data['bukti_kecurangan'] ?? null,
                // jadwal: data['jadwal'] ?? null,
                portofolio: data['portofolio'] ?? null
            };

            Object.entries(fileData).forEach(([id, url]) => {
                let inputElement = document.getElementById(id);
                let container = inputElement.parentNode;

                if (url) {
                    // Create a hyperlink element
                    let link = document.createElement('a');
                    link.href = url;
                    link.target = "_blank";
                    link.className = "text-white underline";
                    link.innerText = "View File"; // Change text as needed

                    // let linkContainer = document.createElement('div');
                    // linkContainer.className = "flex justify-center"; // Tailwind classes for centering
                    // linkContainer.appendChild(link);

                    //<a href="#" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Read more</a>

                    // Remove the input field and append the link
                    container.removeChild(inputElement);
                    container.appendChild(link);
                } else {
                    let link = document.createElement('span');
                    link.className = "text-white";
                    link.innerText = "None"; // Change text as needed

                    // let linkContainer = document.createElement('div');
                    // linkContainer.className = "flex justify-center"; // Tailwind classes for centering
                    // linkContainer.appendChild(link);

                    // Remove the input field and append the link
                    container.removeChild(inputElement);
                    container.appendChild(link);
                }
            });
        };
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
