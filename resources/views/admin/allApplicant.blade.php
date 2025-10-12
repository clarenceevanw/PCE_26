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




</div>
@endSection

@section('script')
    <script>
        const data = JSON.parse(@json($datas));
        const customDatatable = document.getElementById("datatable");
        const applicantDetailUrl = "{{ route('admin.applicantDetail', ['applicantId' => ':applicant_id']) }}";

        const instance = new te.Datatable(
        customDatatable,
        {
            columns: [
            { label: "NRP", field: "nrp", sort: true },
            { label: "Name", field: "name", sort: true },
            { label: "Division 1", field: "divisi1", sort: true},
            { label: "Result", field: "result1"},
            { label: "Division 2", field: "divisi2", sort: true},
            { label: "Result", field: "result2"},
            { label: "Detail", field: "detail"},
            ],
            rows: data.map((item) => {
                return {
                    ...item,
                    detail : `
                    <button
                    type="button"
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    onclick="window.location.href='${applicantDetailUrl.replace(':applicant_id', item.id)}'">
                        <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">
        
                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>
        
                        </svg>
                    </button>
                    `,
                    result1: item.result1 
                    ? `<a href="${item.result1}" target="_blank" class="text-blue-500 hover:underline">View Result</a>` 
                    : `<span class="text-red-500">No Result</span>`,
                    result2: item.result2 
                    ? `<a href="${item.result2}" target="_blank" class="text-blue-500 hover:underline">View Result</a>` 
                    : `<span class="text-red-500">No Result</span>`,
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


        if(data.status1 == 1){
            document.getElementById('actionButton1').innerHTML = `
                <span class="text-green-500">Diterima</span>
            `
            document.getElementById('actionButton2').innerHTML = `
                <span class="text-red-500">Ditolak</span>
            `
        }
        if(data.status2 == 1){
            document.getElementById('actionButton2').innerHTML = `
                <span class="text-green-500">Diterima</span>
            `
            document.getElementById('actionButton1').innerHTML = `
                <span class="text-red-500">Ditolak</span>
            `
        }

        function accept(division_name, applicant_id, isAccepted){
            Swal.fire({
                title: "Are you sure?",
                text: "The data cannot be changed!",
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
                    var method = 'POST';
                    var url = "{{ route('admin.accApplicant.store') }}";
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');

                    // var loader = document.querySelector(".data-loader");
                    // loader.classList.remove("hidden");
                    // loader.classList.add("flex");
                    $.ajax({
                        type: method,
                        url: url,
                        data: {
                            division_name: division_name,
                            applicant_id: applicant_id,
                            isAccepted: isAccepted,
                            _token: csrfToken
                        },
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
        }
    </script>
@endSection