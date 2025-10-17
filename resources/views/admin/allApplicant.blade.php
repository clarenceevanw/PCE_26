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
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
<script>
    const data = JSON.parse(@json($datas));
    const customDatatable = document.getElementById("datatable");
    const applicantDetailUrl = "{{ route('admin.applicantDetail', ['applicantId' => ':applicant_id']) }}";

    // Inisialisasi Datatable
    const instance = new te.Datatable(customDatatable, {
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
    }, { hover: true, stripped: true });

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
</script>
@endsection
