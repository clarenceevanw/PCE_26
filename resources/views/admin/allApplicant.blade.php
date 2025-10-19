@extends('admin.layout')

@section('style')
@endsection

@section('content')
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8">
    <!-- Search -->
    <div class="px-8 w-full mb-3">
        <div class="relative mb-4 flex w-full flex-wrap items-stretch">
            <input
                id="advanced-search-input"
                type="search"
                class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                placeholder="Search"
                aria-label="Search"
                aria-describedby="button-addon1" />
            
            <!-- Search button -->
            <button
                class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 focus:bg-primary-700 focus:outline-none"
                type="button"
                id="advanced-search-button"
                data-te-ripple-init
                data-te-ripple-color="light">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd"
                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div class="px-3 flex justify-end">
                <button onclick="showFilter()" class="tabButton w-32 inline-block rounded bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] disable-button-while-submit">Filter <i class="fa fa-filter ml-3" aria-hidden="true"></i></button>
            </div>
        </div>
    </div>

    <!-- Datatable -->
    <div id="datatable" class="w-full px-5 py-5"></div>

    <div class="w-full px-8">
        <div class="flex justify-center">
            <div class="flex items-center mx-auto">
                <button
                    type="button"
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    class="inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow transition duration-150 ease-in-out"
                    disabled>
                    <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z">
                        </path>
                    </svg>
                </button>
                <span class="text-sm italic p-1"> : Applicant Detail</span>
            </div>
        </div>
    </div>
    <div id="modalFilter" class="h-screen overflow-y-auto overflow-x-hidden fixed top-0 left-0 z-[3000] justify-center items-center w-screen hscreen md:inset-0 bg-black bg-opacity-50 opacity-0 hidden transition-opacity duration-500">
            <div class="relative p-4 w-full max-w-md md:max-w-3xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Custom Filter
                        </h3>
                        <button onclick="closeFilter()" type="button" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Divisi Pertama</label>
                                <select style="width:100%" id="filterDivisi1" name="filterDivisi1">
                                    <option>ALL</option>
                                    @foreach($divisions as $div)
                                        <option value="{{ $div->name }}">{{ $div->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Divisi Kedua</label>
                                <select style="width:100%" id="filterDivisi2" name="filterDivisi2">
                                    <option>ALL</option>
                                    @foreach($divisions as $div)
                                        <option value="{{ $div->name }}">{{ $div->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w-full flex-row flex justify-center items-center">
                            <button id="buttonReset" class="m-3 w-32 text-white bg-[#cc0000] hover:bg-[#b30000] focus:ring-4 focus:outline-none focus:ring-[#990000] font-medium rounded-lg text-sm px-5 py-2.5 text-center">Reset</button>
                            <button id="buttonFilter" class="m-3 w-32 text-white bg-[#0bd865] hover:bg-[#09c25b] focus:ring-4 focus:outline-none focus:ring-[#038b02] font-medium rounded-lg text-sm px-5 py-2.5 text-center">Apply</button>
                        </div>
                </div>
            </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
<script>
    const data = JSON.parse(@json($datas));
    const customDatatable = document.getElementById("datatable");
    const applicantDetailUrl = "{{ route('admin.applicantDetail', ['applicantId' => ':applicant_id']) }}";

    // Inisialisasi Datatable
    const display = (data) => {
        let instance = null;
        instance = new te.Datatable(customDatatable, {
            columns: [
                { label: "NRP", field: "nrp", sort: true },
                { label: "Name", field: "name", sort: true },
                { label: "Division 1", field: "divisi1", sort: true },
                { label: "Result", field: "result1" },
                { label: "Division 2", field: "divisi2", sort: true },
                { label: "Result", field: "result2" },
                { label: "Detail", field: "detail" },
            ],
            rows: data.map((item) => ({
                ...item,
                detail: `
                    <button
                        type="button"
                        class="inline-block rounded-full border border-primary bg-primary text-white p-1.5 shadow hover:bg-primary-700 transition"
                        onclick="window.location.href='${applicantDetailUrl.replace(':applicant_id', item.id)}'">
                        <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z">
                            </path>
                        </svg>
                    </button>
                `,
                result1: item.result1
                    ? `<button onclick="resultInformation('${item.result1}', ${item.status1})" class="text-white p-2 bg-blue-500 rounded hover:bg-blue-600 transisition duration-300 ease-in-out">View Result</button>`
                    : `<span class="text-red-500">No Result</span>`,
                result2: item.result2
                    ? `<button onclick="resultInformation('${item.result2}', ${item.status2})" class="text-white p-2 bg-blue-500 rounded hover:bg-blue-600 transisition duration-300 ease-in-ou">View Result</button>`
                    : `<span class="text-red-500">No Result</span>`,
            })),
        }, 
        { hover: true, stripped: true , scrollX: true });
    
        // Search logic
        const advancedSearchInput = document.getElementById('advanced-search-input');
    
        function search(value) {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());
            if (columns) {
                columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }
            instance.search(phrase, columns);
        }
    
        document.getElementById("advanced-search-button").addEventListener("click", () => {
            search(advancedSearchInput.value);
        });
    
        advancedSearchInput.addEventListener("keydown", (e) => {
            search(e.target.value);
        });
    }

    display(data);

    // Fungsi menampilkan detail hasil
    function resultInformation(itemResult, itemStatus) {
        const statusText =
            itemStatus === null
                ? 'Pending'
                : itemStatus == 0
                    ? 'Rejected'
                    : 'Accepted';

        const html = `
            <a href="${itemResult}" target="_blank" class="text-blue-500 hover:underline block mb-2">Hasil Interview</a>
            <span>Status Terima: <b>${statusText}</b></span>
        `;

        Swal.fire({
            title: 'Result Information',
            html: html,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Close',
        });
    }
</script>
<script>
    const filterModal = document.getElementById('modalFilter');
    const filterDivisi1 = document.getElementById('filterDivisi1');
    const filterDivisi2 = document.getElementById('filterDivisi2');
    window.showFilter = function() {
        filterModal.classList.remove("hidden");
        filterModal.classList.add("flex");
        setTimeout(() => {
            filterModal.classList.add("opacity-100");
        }, 10);
    }

    window.closeFilter = function() {
        filterModal.classList.remove("opacity-100");
        setTimeout(() => {
            filterModal.classList.add("hidden");
            filterModal.classList.remove("flex");
        }, 500);
    }
    
    function applyFilter() {

        const filters = {
            divisi1: filterDivisi1.value,
            divisi2: filterDivisi2.value,
        };

        const filteredData = data.filter(item => {
            return Object.keys(filters).every(key => {
                if (filters[key] === "ALL") {
                    return true;
                }
                return item[key] == filters[key];
            });
        });
        document.getElementById("datatable").replaceChildren();
        display(filteredData); // Refresh the datatable with filtered data
        closeFilter();
    }
    function resetFilter() {
        // Reset the form fields
        filterDivisi1.value = "ALL";
        filterDivisi2.value = "ALL";
        document.getElementById("datatable").replaceChildren();
        display(datas); 
    }
    document.getElementById('buttonFilter').addEventListener('click', applyFilter);
    document.getElementById('buttonReset').addEventListener('click', resetFilter);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' || e.key === 'Esc') {
            if (!filterModal.classList.contains('hidden')) {
                closeFilter();
            }
        }
    });
</script>
@endsection
