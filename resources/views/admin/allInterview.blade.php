@extends('admin.layout')

@section('style')
@endsection

@section('content')
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8">
    <div class="px-8 w-full mb-3">
        <div class="relative mb-4 flex w-full flex-wrap items-stretch">
        <input
            id="advanced-search-input"
            type="search"
            class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
            placeholder="Search"
            aria-label="Search"
            aria-describedby="button-addon1" />
            
            <!--Search button-->
        <button
            class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
            type="button"
            id="advanced-search-button"
            data-te-ripple-init
            data-te-ripple-color="light">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
            class="h-5 w-5">
            <path
                fill-rule="evenodd"
                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                clip-rule="evenodd" />
            </svg>
        </button>
        </div>
    </div>
    <div id="datatable" class="w-full px-5 py-5"></div>
    <div class="w-full px-8">
        <div class="flex justify-center">
            <div class="flex items-center mx-auto">
                <button
                type="button"
                data-te-ripple-init
                data-te-ripple-color="light"
                class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]" disabled>
                    <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">
    
                    <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>
    
                    </svg>
                </button>
                <span class="text-sm italic p-1"> : Applicant Detail</span>
            </div>
        </div>
    </div>




    <div id="modal" class="z-[2000] h-full overflow-y-auto overflow-x-hidden fixed top-0 left-0 z-50 flex justify-center items-center w-screen hscreen md:inset-0 h-[calc(100%-1rem)] bg-black bg-opacity-50 opacity-0 hidden transition-opacity duration-500">
        <!-- Modal goes here -->
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 id="modalTitle" class="text-xl font-semibold text-gray-900 dark:text-white">

                    </h3>
                    <button onclick="closeModal()" type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div id="modalBody" class="p-4 md:p-5 max-h-[400px] overflow-auto">
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endSection

@section('script')
<script>
        const customDatatable = document.getElementById("datatable");
        const datas = JSON.parse(@json($datas));

        const applicantDetailUrl = "{{ route('admin.applicantDetail', ['applicantId' => ':applicant_id']) }}";
        const instance = new te.Datatable(
        customDatatable,
        {
            columns: [
            { label: "Admin", field: "adminName",  sort: false},
            { label: "Divisi", field: "divisi",  sort: false},
            { label: "Date", field: "date",  sort: true},
            { label: "Time", field: "time", sort: false },
            { label: "Name", field: "name", sort: false },
            { label: "Status", field: "statusInterview", sort: false },
            { label: "Result", field: "result", sort: false },
            { label: "Action", field: "action"},
            ],
            rows: datas.map((item) => {
                return {
                    ...item,
                    result: item.link_hasil 
                    ? `<a href="${item.link_hasil}" target="_blank" class="text-blue-500 hover:underline">View Result</a>` 
                    : `<span class="text-red-500">No Result</span>`,
                    action : `
                        <button
                            type="button"
                            onclick="window.location.href='${applicantDetailUrl.replace(':applicant_id', item.applicant_id)}'"
                            data-te-ripple-init
                            data-te-ripple-color="light"
                            class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            <svg class="w-4 h-4 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                            </svg>
                        </button>
                    `,
                }
            }),
        },
        { hover: true, stripped : true }
        );
        const advancedSearchInput = document.getElementById('advanced-search-input');

        const search = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instance.search(phrase, columns);
        };

        document
            .getElementById("advanced-search-button")
            .addEventListener("click", (e) => {
            search(advancedSearchInput.value);
            });

        advancedSearchInput.addEventListener("keydown", (e) => {
            search(e.target.value);
        });
    </script>
    <script>
        function openModal(nrp){
            let data = searchDataByNrp(nrp);
            let modal = document.getElementById('modal');
            modal.classList.remove("hidden")
            setTimeout(()=>{
                modal.classList.add("opacity-100")
            },10)
            $('#modalTitle').text('Submit Hasil Interview')
            $('#modalBody').html(`
            <form id="form_hasil" class="w-full" method="post" action="{{ route('admin.hasilInterview.store') }}">
                @csrf
                <div class="grid md:grid-cols-1 gap-6 mb-10">
                    <div class="flex flex-col w-full md:w-full">
                        <label for="portofolio" class="block mb-2 text-sm font-medium text-gray-900">Link Google Docs</label>
                        <input type="text" id="link_hasil" name="link_hasil"
                            class="border border-gray-400 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Link Google Docs..."/>
                        <input type="text" id="nrp" value="${data.nrp}" name="nrp" hidden>
                    </div>
                </div>

                <button type="submit" id="submitHasil"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
            `
            )
            $("#form_hasil").on('submit', function(e){
                e.preventDefault();

                Swal.fire({
                    title: "Are you sure want to submit?",
                    text: "Make sure the link is correct. Once you submit, the link cannot be changed!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, submit it!",
                    didOpen: () => {
                        // Set custom z-index for the Swal container and backdrop
                        document.querySelector('.swal2-container').style.zIndex = '2002'; // Adjust z-index as needed
                        document.querySelector('.swal2-backdrop-show').style.zIndex = '2001'; // Adjust backdrop z-index if needed
                    }
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
                                        confirmButtonText: "OK",
                                        didOpen: () => {
                                            // Set custom z-index for the Swal container and backdrop
                                            document.querySelector('.swal2-container').style.zIndex = '2002'; // Adjust z-index as needed
                                            document.querySelector('.swal2-backdrop-show').style.zIndex = '2001'; // Adjust backdrop z-index if needed
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.reload();
                                        }
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 1500);

                                    });
                                } else {
                                    await Swal.fire({
                                        icon: "error",
                                        title: "Oops...",
                                        text: response.message,
                                        confirmButtonColor: "#3085d6",
                                        didOpen: () => {
                                            // Set custom z-index for the Swal container and backdrop
                                            document.querySelector('.swal2-container').style.zIndex = '2002'; // Adjust z-index as needed
                                            document.querySelector('.swal2-backdrop-show').style.zIndex = '2001'; // Adjust backdrop z-index if needed
                                        }
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
                                    confirmButtonText: 'OK',
                                    didOpen: () => {
                                        // Set custom z-index for the Swal container and backdrop
                                        document.querySelector('.swal2-container').style.zIndex = '2002'; // Adjust z-index as needed
                                        document.querySelector('.swal2-backdrop-show').style.zIndex = '2001'; // Adjust backdrop z-index if needed
                                    }
                                });
                            }
                        })
                    } else {
                        // User canceled the submission
                        Swal.fire({
                            title: "Cancelled!",
                            text: "Your link was not submitted.",
                            icon: "info",
                            confirmButtonColor: "#3085d6",
                            confirmButtonText: "OK",
                            didOpen: () => {
                                // Set custom z-index for the Swal container and backdrop
                                document.querySelector('.swal2-container').style.zIndex = '2002'; // Adjust z-index as needed
                                document.querySelector('.swal2-backdrop-show').style.zIndex = '2001'; // Adjust backdrop z-index if needed
                            }
                        });
                    }
                });
            })

        }

        function searchDataByNrp(nrp){
            return datas.find(item => item.nrp === nrp);
        }

        //hide modal
        function closeModal(){
            let modal = document.getElementById('modal')
            modal.classList.add("opacity-0")    
            modal.classList.remove("opacity-100")
            setTimeout(()=>{
                modal.classList.add("hidden")
            },250)
        }
    </script>
@endSection