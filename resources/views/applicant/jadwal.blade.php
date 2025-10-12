@extends('layout')
@section('head')
<style>
    .custom-dropdown option {
        background-color: #1f4b46; /* Semi-transparent background */
        color: #FBBF24; /* Text color */
        backdrop-filter: blur(5px); /* Blurry background effect */
    }
</style>
@endsection
@section('content')
    <div class="background flex flex-col w-screen h-full sm:min-h-screen items-center p-8 sm:p-14">
        <div class="flex flex-col w-9/12">
            <div class="flex w-full justify-between">
                <a href="{{ route('applicant.berkas') }}">
                    <button
                        class="bg-pink-600 px-3 py-1 border-danger border-2 text-yellow-400 text-sm font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">
                        Back
                    </button>
                </a>
                <a href="{{ route('applicant.homepage') }}" id="backToHomepage">
                    <button
                        class="hidden bg-pink-600 px-3 py-1 border-danger border-2 text-yellow-400 text-sm font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">
                        Back to Homepage
                    </button>
                </a>
            </div>
            <h1 class="font-squids text-shadow text-white text-4xl font-bold text-center my-8">{{ $title }}</h1>
            <div id="containerJadwal" class="flex flex-col w-full border-4 border-white bg-transparent bg-blur py-4 px-5 flex mx-auto block shadow-4 justify-center items-center">
                <form id="form_jadwal" class="w-full" method="post" action="{{ route('applicant.jadwal.store') }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-6 mb-10">
                        <div>
                            <h1 class="font-organetto block mb-2 text-md font-medium text-yellow-400">Divisi 1</h1>
                            <div class="flex">
                                <select id="hari_choice1" name="hari_choice1"
                                    class="custom-dropdown mx-2 border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option selected readonly hidden value="">Hari</option>
                                </select>
                                <select id="tanggal_choice1" name="tanggal_choice1"
                                    class="custom-dropdown mx-2 border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" disabled>
                                    <option selected readonly hidden value="">Tanggal</option>
                                </select>
                                <select id="jam_choice1" name="jam_choice1"
                                    class="custom-dropdown mx-2 border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" disabled>
                                    <option selected readonly hidden value="">Jam</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <h1 class="font-organetto block mb-2 text-md font-medium text-yellow-400">Divisi 2</h1>
                            <div id="jadwal_choice2" class="flex">
                                <select id="hari_choice2" name="hari_choice2"
                                    class="custom-dropdown mx-2 border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option selected readonly hidden value="">Hari</option>
                                </select>
                                <select id="tanggal_choice2" name="tanggal_choice2"
                                    class="custom-dropdown mx-2 border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" disabled>
                                    <option selected readonly hidden value="">Tanggal</option>
                                </select>
                                <select id="jam_choice2" name="jam_choice2"
                                    class="custom-dropdown mx-2 border border-white font-organetto-light bg-transparent text-white text-md focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" disabled>
                                    <option selected readonly hidden value="">Jam</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="submitJadwal"
                        class="bg-pink-600 w-full border-danger border-2 px-6 pb-2 pt-2.5 text-yellow-400 text-lg font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">Submit</button>
                </form>
                <button id="finishPage" onclick="window.location.href='{{ route('applicant.berkas') }}'"
                    class="hidden bg-pink-600 w-full border-danger border-2 px-6 pb-2 pt-2.5 text-yellow-400 text-lg font-extrabold uppercase leading-normal text-white transition duration-300 ease-in-out hover:bg-yellow-400 hover:text-pink-600 hover:border-yellow-400 hover:shadow-yellow-200 focus:bg-yellow-accent-200 focus:outline-none focus:ring-0 active:bg-yellow-600 motion-reduce:transition-none">Finish</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    var schedules = JSON.parse(@json($schedules));
    var hariDiv1 = document.getElementById('hari_choice1');
    var tanggalDiv1 = document.getElementById('tanggal_choice1');
    var jamDiv1 = document.getElementById('jam_choice1');
    var hariDiv2 = document.getElementById('hari_choice2');
    var tanggalDiv2 = document.getElementById('tanggal_choice2');
    var jamDiv2 = document.getElementById('jam_choice2');
    var uniqueDays = new Set();
    schedules.division1.forEach(sch1 => {
        let dateString = sch1.tanggal;
        let currentDateTime = new Date();
        let date = new Date(dateString);

        //check if current date is lower than the date
        if (date >= currentDateTime){
            let options = { weekday: 'long' };

            let formattedDay = new Intl.DateTimeFormat('id-ID', options).format(date);
            
            // Check if the day is already in the Set
            if (!uniqueDays.has(formattedDay)) {
                // If not, add the day to the Set and the dropdown
                uniqueDays.add(formattedDay);
                hariDiv1.innerHTML += `
                <option value='${formattedDay}'>${formattedDay}</option>
                `;
            }
        }
    });
    hariDiv1.addEventListener('change', function() {
        tanggalDiv1.disabled = false;
        tanggalDiv1.innerHTML = `<option selected readonly hidden value="">Tanggal</option>`;
        var selectedValue = this.value;
        var uniqueDate = new Set();
        schedules.division1.forEach(sch1 => {
            let dateString = sch1.tanggal;
            let currentDateTime = new Date();
            let date = new Date(dateString);

            //check if current date is lower than the date
            if (date >= currentDateTime){
                let options = { weekday: 'long' };

                let formattedDay = new Intl.DateTimeFormat('id-ID', options).format(date);
                
                if (formattedDay == selectedValue) {
                    options = {month: 'long', day: 'numeric'}
                    formattedDate = new Intl.DateTimeFormat('id-ID', options).format(date);
                    if (!uniqueDate.has(formattedDate)) {
                        uniqueDate.add(formattedDate);
                        console.log(uniqueDate);
                        tanggalDiv1.innerHTML += `
                        <option value='${sch1.tanggal}'>${formattedDate}</option>
                        `;
                    }
                }
            }
        });
    });
    tanggalDiv1.addEventListener('change', function() {
        jamDiv1.disabled = false;
        jamDiv1.innerHTML = `<option selected readonly hidden value="">Jam</option>`;
        var selectedValue = this.value;
        schedules.division1.forEach(sch1 => {
            let dateString = sch1.tanggal;
            let timeString = sch1.jam_mulai;
            
            if (dateString == selectedValue) {
                let [hours, minutes] = timeString.split(':').map(Number);
                let scheduledTime = new Date(new Date(dateString).setHours(hours, minutes));
                let currentTime = new Date();

                // Check if the scheduled time is within the next 2 hours
                let twoHoursFromNow = new Date(currentTime.getTime() + 2 * 60 * 60 * 1000);
                
                // Only add the option if the scheduled time is not within the next 2 hours
                if (scheduledTime >= twoHoursFromNow) {
                    // Format time to HH:MM
                    let formattedTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
                    jamDiv1.innerHTML += `
                        <option value='${sch1.jam_mulai}'>${formattedTime}</option>
                    `;
                }
                
            }
        });
    });

    //untuk divisi 2
    uniqueDays = new Set();
    if(schedules.division2){
        schedules.division2.forEach(sch2 => {
            let dateString = sch2.tanggal;
            let currentDateTime = new Date();
            let date = new Date(dateString);

            //check if current date is lower than the date
            if (date >= currentDateTime){
                let options = { weekday: 'long' };

                let formattedDay = new Intl.DateTimeFormat('id-ID', options).format(date);
                
                // Check if the day is already in the Set
                if (!uniqueDays.has(formattedDay)) {
                    // If not, add the day to the Set and the dropdown
                    uniqueDays.add(formattedDay);
                    hariDiv2.innerHTML += `
                    <option value='${formattedDay}'>${formattedDay}</option>
                    `;
                }
            }
        });
        hariDiv2.addEventListener('change', function() {
            tanggalDiv2.disabled = false;
            tanggalDiv2.innerHTML = `<option selected readonly hidden value="">Tanggal</option>`;
            var selectedValue = this.value;
            var uniqueDate = new Set();
            schedules.division2.forEach(sch2 => {
                let dateString = sch2.tanggal;
                let currentDateTime = new Date();
                let date = new Date(dateString);

                //check if current date is lower than the date
                if (date >= currentDateTime){
                    let options = { weekday: 'long' };

                    let formattedDay = new Intl.DateTimeFormat('id-ID', options).format(date);
                    
                    if (formattedDay == selectedValue) {
                        options = {month: 'long', day: 'numeric'}
                        formattedDate = new Intl.DateTimeFormat('id-ID', options).format(date);
                        if (!uniqueDate.has(formattedDate)) {
                            uniqueDate.add(formattedDate);
                            console.log(uniqueDate);
                            tanggalDiv2.innerHTML += `
                            <option value='${sch2.tanggal}'>${formattedDate}</option>
                            `;
                        }
                    }
                }
            });
        });
        tanggalDiv2.addEventListener('change', function() {
            jamDiv2.disabled = false;
            jamDiv2.innerHTML = `<option selected readonly hidden value="">Jam</option>`;
            var selectedValue = this.value;
            schedules.division2.forEach(sch2 => {
                let dateString = sch2.tanggal;
                let timeString = sch2.jam_mulai;
                
                if (dateString == selectedValue) {
                    let [hours, minutes] = timeString.split(':').map(Number);
                    let scheduledTime = new Date(new Date(dateString).setHours(hours, minutes));
                    let currentTime = new Date();

                    // Check if the scheduled time is within the next 2 hours
                    let twoHoursFromNow = new Date(currentTime.getTime() + 2 * 60 * 60 * 1000);
                    
                    // Only add the option if the scheduled time is not within the next 2 hours
                    if (scheduledTime >= twoHoursFromNow) {
                        // Format time to HH:MM
                        let formattedTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
                        jamDiv2.innerHTML += `
                            <option value='${sch2.jam_mulai}'>${formattedTime}</option>
                        `;
                    }
                    
                }
            });
        });
    }else{
        hariDiv2.style.display = 'none';
        tanggalDiv2.style.display = 'none';
        jamDiv2.style.display = 'none';
        document.getElementById('jadwal_choice2').innerHTML+=`
        <h1 class="font-organetto block mb-2 text-md font-medium text-gray-400">You didn't choice Division 2</h1>
        `
    }




    var interviews = JSON.parse(@json($interviews));
    //console.log(interviews)
    var isExists = JSON.parse(@json($isExists));
    if (isExists) {
        document.getElementById('backToHomepage').hidden = false;
        document.getElementById('form_jadwal').hidden = true;
        const gridContainer = document.createElement("div");
        gridContainer.className = "grid grid-cols-1 xl:grid-cols-2 gap-6 sm:gap-10 max-w-5xl w-full mx-auto";

        const divisiNames = ["Divisi 1", "Divisi 2"];

        Object.entries(interviews).forEach(([key, value], index) => {
            let dateString = value.tanggal;
            let formattedDate = null;
            if (dateString) {
                let date = new Date(dateString);
                let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                formattedDate = new Intl.DateTimeFormat('id-ID', options).format(date);
            }
            
            let formattedTime = null;
            if (value.jam) {
                let [hours, minutes] = value.jam.split(':');
                formattedTime = `${hours}:${minutes}`;
            }

            const cell = document.createElement("div");
            cell.innerHTML = `
            <div class="space-y-2 p-4 border border-gray-200 rounded-lg text-white">
                <div class="font-bold text-center">${divisiNames[index]}</div> <!-- Divisi Header -->
                <div class="grid grid-cols-1 sm:grid-cols-[120px_1fr] gap-y-1 sm:gap-x-2">
                    <div class="font-semibold">Pewawancara:</div> 
                    <div class="whitespace-normal break-words">${value.adminName || "N/A"}</div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-[120px_1fr] gap-y-1 sm:gap-x-2">
                    <div class="font-semibold">Link GMeet:</div> 
                    <div class="whitespace-normal break-words">${value.link_gmeet || "N/A"}</div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-[120px_1fr] gap-y-1 sm:gap-x-2">
                    <div class="font-semibold">Hari, Tanggal:</div> 
                    <div class="whitespace-normal break-words">${formattedDate || "N/A"}</div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-[120px_1fr] gap-y-1 sm:gap-x-2">
                    <div class="font-semibold">Jam:</div> 
                    <div class="whitespace-normal break-words">${formattedTime || "N/A"}</div>
                </div>
            </div>
            `;
            gridContainer.appendChild(cell);
        });



        document.getElementById('containerJadwal').appendChild(gridContainer);
    }





    $("#form_jadwal").on('submit', function(e){
        e.preventDefault();
        document.getElementById('submitJadwal').disabled = true;

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
                if (document.getElementById('jadwal_choice2').value === null){
                    formData.append(document.getElementById('jadwal_choice2').name, null);
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
                                confirmButtonColor: "#3085d6",
                                html: response.message,
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