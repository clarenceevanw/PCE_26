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
</div>
@endSection

@section('script')
    <script>
        const data = @json($datas);
        const customDatatable = document.getElementById("datatable");
        const applicantDetailUrl = "{{ route('admin.applicantDetail', ['applicantId' => ':applicant_id']) }}";

        function renderActionColumn(item, divisionNumber) {
            const divisionName = item[`divisi${divisionNumber}`];
            const status = item[`status${divisionNumber}`];

            // Jika tidak ada divisi kedua, kembalikan 'None'
            if (!divisionName) return 'None';

            // Jika sudah ada status (diterima/ditolak)
            if (status === 1) return `<span class="font-semibold text-green-500">Diterima</span>`;
            if (status === 0) return `<span class="font-semibold text-red-500">Ditolak</span>`;

            // Jika belum ada status, tampilkan tombol
            // Tambahkan data-attributes unik untuk identifikasi
            return `
                <div class="flex gap-2" 
                    data-applicant-id="${item.id}" 
                    data-division-name="${divisionName}" 
                    data-division-num="${divisionNumber}">
                    <button type="button" onclick='handleAction("${divisionName}", "${item.id}", 1)'
                        class="p-1.5 bg-green-500 rounded-full text-white hover:bg-green-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4"><path fill="currentColor" d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                    </button>
                    <button type="button" onclick='handleAction("${divisionName}", "${item.id}", 0)'
                        class="p-1.5 bg-red-500 rounded-full text-white hover:bg-red-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="w-4 h-4"><path fill="currentColor" d="M376.6 84.5c11.3-13.6 9.5-33.8-4.1-45.1s-33.8-9.5-45.1 4.1L192 206 56.6 43.5C45.3 29.9 25.1 28.1 11.5 39.4S-3.9 70.9 7.4 84.5L150.3 256 7.4 427.5c-11.3 13.6-9.5 33.8 4.1 45.1s33.8 9.5 45.1-4.1L192 306 327.4 468.5c11.3 13.6 31.5 15.4 45.1 4.1s15.4-31.5 4.1-45.1L233.7 256 376.6 84.5z"/></svg>
                    </button>
                </div>
            `;
        }
        const instance = new te.Datatable(customDatatable, {
            columns: [
                { label: "NRP", field: "nrp", sort: true },
                { label: "Name", field: "name", sort: true },
                { label: "Division 1", field: "divisi1", sort: true },
                { label: "Action", field: "action1", sort: false },
                { label: "Result", field: "result1", sort: false },
                { label: "Division 2", field: "divisi2", sort: true },
                { label: "Action", field: "action2", sort: false },
                { label: "Result", field: "result2", sort: false },
                { label: "Detail", field: "detail", sort: false },
            ],
            rows: data.map((item) => ({
                ...item,
                action1: renderActionColumn(item, 1),
                action2: renderActionColumn(item, 2),
                result1: item.result1 ? `<a href="${item.result1}" target="_blank" class="text-blue-500 hover:underline">View</a>` : `<span class="text-gray-400">None</span>`,
                result2: item.result2 ? `<a href="${item.result2}" target="_blank" class="text-blue-500 hover:underline">View</a>` : `<span class="text-gray-400">None</span>`,
                detail: `<button type="button" class="text-white bg-primary hover:bg-primary-700 font-medium rounded-lg text-sm px-3 py-1.5" onclick="window.location.href='${applicantDetailUrl.replace(':applicant_id', item.id)}'">Details</button>`
            })),
        }, { hover: true, stripped: true });

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

        function handleAction(division_name, applicant_id, isAccepted){
            const actionText = isAccepted ? 'menerima' : 'menolak';
            Swal.fire({
                title: `Yakin ingin ${actionText} pelamar ini?`,
                text: "Data tidak dapat diubah setelah disubmit!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Submit!",
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
                    
                    Swal.fire({
                        title: "Please wait...",
                        showConfirmButton: false,
                        didOpen: () => {
                            // Set custom z-index for the Swal container and backdrop
                            document.querySelector('.swal2-container').style.zIndex = '2002'; // Adjust z-index as needed
                            document.querySelector('.swal2-backdrop-show').style.zIndex = '2001'; // Adjust backdrop z-index if needed
                            Swal.showLoading();
                        }
                    });
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
                            await Swal.close();
                            if (response.success) {
                                Swal.fire({
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
                                });
                                const actionDiv = document.querySelector(`div[data-applicant-id="${applicant_id}"][data-division-name="${division_name}"]`);
                                if (actionDiv) {
                                    const newStatus = isAccepted 
                                        ? `<span class="font-semibold text-green-500">Diterima</span>` 
                                        : `<span class="font-semibold text-red-500">Ditolak</span>`;
                                    actionDiv.innerHTML = newStatus;
                                }
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
                            await Swal.close();
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