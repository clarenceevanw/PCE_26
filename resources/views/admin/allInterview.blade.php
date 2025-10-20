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
        <div class="px-3 flex justify-end">
                <button onclick="showFilter()" class="tabButton w-32 inline-block rounded bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] disable-button-while-submit">Filter <i class="fa fa-filter ml-3" aria-hidden="true"></i></button>
        </div>
        </div>
    </div>
    <div id="datatable" class="w-full px-5 py-5"></div>
    <div class="w-full px-8">
        <div class="flex justify-center">
            <div class="flex items-center mx-auto mr-1 md:mr-0">
                <button
                type="button"
                data-te-ripple-init
                data-te-ripple-color="dark"
                class="inline-block rounded-full border border-black p-1.5 mr-1 uppercase leading-normal shadow-[0_4px_9px_-4px_#000] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M320 96C239.2 96 174.5 132.8 127.4 176.6C80.6 220.1 49.3 272 34.4 307.7C31.1 315.6 31.1 324.4 34.4 332.3C49.3 368 80.6 420 127.4 463.4C174.5 507.1 239.2 544 320 544C400.8 544 465.5 507.2 512.6 463.4C559.4 419.9 590.7 368 605.6 332.3C608.9 324.4 608.9 315.6 605.6 307.7C590.7 272 559.4 220 512.6 176.6C465.5 132.9 400.8 96 320 96zM176 320C176 240.5 240.5 176 320 176C399.5 176 464 240.5 464 320C464 399.5 399.5 464 320 464C240.5 464 176 399.5 176 320zM320 256C320 291.3 291.3 320 256 320C244.5 320 233.7 317 224.3 311.6C223.3 322.5 224.2 333.7 227.2 344.8C240.9 396 293.6 426.4 344.8 412.7C396 399 426.4 346.3 412.7 295.1C400.5 249.4 357.2 220.3 311.6 224.3C316.9 233.6 320 244.4 320 256z"/></svg>
                </button>
                <span class="text-sm italic p-1"> : View Interview Result</span>
            </div>
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
    <div id="modal" class="z-[4000] h-full overflow-y-auto overflow-x-hidden fixed top-0 left-0 justify-center items-center w-screen hscreen md:inset-0 bg-black bg-opacity-50 opacity-0 hidden transition-opacity duration-500">
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
@endSection

@section('script')
<script>
        const customDatatable = document.getElementById("datatable");
        const datas = JSON.parse(@json($datas));

        const applicantDetailUrl = "{{ route('admin.applicantDetail', ['applicantId' => ':applicant_id']) }}";
        const display = (data) => {
            let instance = null;

            instance = new te.Datatable(
            customDatatable,
            {
                columns: [
                { label: "Admin", field: "adminName",  sort: false},
                { label: "Divisi", field: "divisi",  sort: false},
                { label: "Date", field: "date",  sort: true},
                { label: "Time", field: "time", sort: false },
                { label: "NRP", field: "nrp", sort: true },
                { label: "Name", field: "name", sort: false },
                { label: "Division 1", field: "divisi1", sort: false },
                { label: "Division 2", field: "divisi2", sort: false },
                { label: "Status", field: "statusInterview", sort: false },
                { label: "Result", field: "result", sort: false },
                { label: "Action", field: "action"},
                ],
                rows: data.map((item) => {
                    return {
                        ...item,
                        result: item.link_hasil_result1 && item.link_hasil_result2
                        ? `<button
                            type="button"
                            onClick="openModalResult('${item.nrp}')"
                            data-te-ripple-init
                            data-te-ripple-color="dark"
                            class="inline-block rounded-full border border-black p-1.5 mr-1 uppercase leading-normal shadow-[0_4px_9px_-4px_#000] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><!--!Font Awesome Free v7.1.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M320 96C239.2 96 174.5 132.8 127.4 176.6C80.6 220.1 49.3 272 34.4 307.7C31.1 315.6 31.1 324.4 34.4 332.3C49.3 368 80.6 420 127.4 463.4C174.5 507.1 239.2 544 320 544C400.8 544 465.5 507.2 512.6 463.4C559.4 419.9 590.7 368 605.6 332.3C608.9 324.4 608.9 315.6 605.6 307.7C590.7 272 559.4 220 512.6 176.6C465.5 132.9 400.8 96 320 96zM176 320C176 240.5 240.5 176 320 176C399.5 176 464 240.5 464 320C464 399.5 399.5 464 320 464C240.5 464 176 399.5 176 320zM320 256C320 291.3 291.3 320 256 320C244.5 320 233.7 317 224.3 311.6C223.3 322.5 224.2 333.7 227.2 344.8C240.9 396 293.6 426.4 344.8 412.7C396 399 426.4 346.3 412.7 295.1C400.5 249.4 357.2 220.3 311.6 224.3C316.9 233.6 320 244.4 320 256z"/></svg>
                            </button>` 
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
        }
        display(datas);
    </script>
    <script>
        const filterModal = document.getElementById('modalFilter');
        const filterDivisi1 = document.getElementById('filterDivisi1');
        const filterDivisi2 = document.getElementById('filterDivisi2');
        function showFilter() {
            filterModal.classList.remove("hidden");
            filterModal.classList.add("flex");
            setTimeout(() => {
                filterModal.classList.add("opacity-100");
            }, 10);
        }

        function closeFilter() {
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

            const filteredData = datas.filter(item => {
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
    <script>
    // PINDAHIN KE SINI - PALING BAWAH!
    window.openModalResult = function(nrp){
        console.log('Button clicked! NRP:', nrp);
        let data = searchDataByNrp(nrp);
        console.log('Data found:', data);
        
        if (!data) {
            console.error('Data not found for NRP:', nrp);
            return;
        }
        
        let modal = document.getElementById('modal');
        let modalTitle = document.getElementById('modalTitle');
        let modalBody = document.getElementById('modalBody');
        
        // **This is the corrected opening logic**
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            modal.classList.add("opacity-100");
        }, 10); // A small delay allows the browser to apply the transition
        
        modalTitle.textContent = 'Hasil Interview';
        modalBody.innerHTML = `
            <div class="grid md:grid-cols-1 gap-6 mb-10">
                <div class="flex flex-col justify-center items-center w-full md:w-full">
                    <a href="${data.link_hasil_result1 || '#'}" target="_blank" class="text-blue-500 hover:underline mb-2">Result Divisi 1</a>
                    <a href="${data.link_hasil_result2 || '#'}" target="_blank" class="text-blue-500 hover:underline">Result Divisi 2</a>
                </div>
            </div>
        `;
    }

    function searchDataByNrp(nrp){
        return datas.find(item => item.nrp === nrp);
    }

    window.closeModal = function(){
        let modal = document.getElementById('modal');
        
        // **This is the corrected closing logic**
        modal.classList.remove("opacity-100");
        setTimeout(() => {
            modal.classList.add("hidden");
            modal.classList.remove('flex');
        }, 500); // Match this duration to your CSS transition (duration-500)
    }
</script>
@endSection