@extends('layout')
@section('content')
<div class="background min-h-screen flex flex-col items-center justify-center px-4 py-6 sm:px-5 lg:px-6">
  <div class="w-full max-w-4xl">
    <!-- Back Buttons -->
    <div class="mb-6 flex justify-between items-center">
      <a href="{{ route('applicant.berkas') }}">
        <button class="px-5 py-2 border border-purple-500 text-white text-sm sm:text-base font-semibold uppercase rounded-full hover:bg-purple-500 transition-all duration-300">
          ← Back
        </button>
      </a>
      <a href="{{ route('applicant.homepage') }}" id="backToHomepage" class="hidden">
        <button class="px-5 py-2 border border-purple-500 text-white text-sm sm:text-base font-semibold uppercase rounded-full hover:bg-purple-500 transition-all duration-300">
          Back to Homepage
        </button>
      </a>
    </div>

    <h1 class="font-return-grid text-white text-2xl sm:text-4xl text-center mb-8 tracking-widest drop-shadow-[0_0_25px_rgba(168,85,247,0.8)]">
      {{ Str::upper($title); }}
    </h1>

    <!-- Main Container -->
    <div class="bg-purple-950/40 backdrop-blur-sm rounded-2xl p-6 border border-purple-500/40">
      <form id="form_jadwal" method="post" action="{{ route('applicant.jadwal.store') }}" class="space-y-6">
        @csrf

        <!-- Interview Mode -->
        <div>
          <label class="font-organetto block text-white text-sm sm:text-base font-semibold uppercase mb-2">Mode Interview</label>
          <div class="grid grid-cols-2 gap-3">
            <label class="cursor-pointer">
              <input type="radio" name="interview_mode" value="1" class="peer sr-only" checked>
              <div class="flex items-center justify-center gap-2 px-4 py-2 border border-purple-500/50 rounded-full text-sm sm:text-base text-white peer-checked:bg-purple-500 peer-checked:shadow-[0_0_15px_rgba(168,85,247,0.5)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
                <span>Online</span>
              </div>
            </label>
            <label class="cursor-pointer">
              <input type="radio" name="interview_mode" value="0" class="peer sr-only">
              <div class="flex items-center justify-center gap-2 px-4 py-2 border border-purple-500/50 rounded-full text-sm sm:text-base text-white peer-checked:bg-purple-500 peer-checked:shadow-[0_0_15px_rgba(168,85,247,0.5)]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Offline</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Division Info -->
        <div class="bg-purple-900/30 border border-purple-500/30 rounded-xl p-4 text-sm sm:text-base text-purple-200">
          <p><span class="font-semibold">Divisi Interview:</span> <span class="text-white">{{ $divisionName }}</span></p>
          <p class="text-purple-300/70 text-xs mt-1">Pilih jadwal sesuai ketersediaan Anda.</p>
        </div>

        <!-- Jadwal Selects -->
        @foreach (['Tanggal' => 'tanggal_choice', 'Jam' => 'jam_choice'] as $label => $id)
          <div>
            <label for="{{ $id }}" class="block mb-2 text-sm text-purple-200 font-organetto">{{ $label }}</label>
            <div class="relative">
              <select id="{{ $id }}" name="{{ $id }}" class="w-full px-4 py-3 bg-transparent border border-purple-500/50 rounded-full text-sm sm:text-base text-white focus:border-purple-400">
                <option class="bg-purple-950" disabled selected hidden>Pilih {{ $label }}</option>
              </select>
              <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </div>
          </div>
        @endforeach

        <button type="submit" id="submitJadwal" class="w-full py-3 border border-purple-500 text-white font-semibold uppercase rounded-full hover:bg-purple-500 transition-all">
          Submit Jadwal
        </button>
      </form>
      <div id="interview_details" class="hidden space-y-8">
            <!-- Details will be populated by JavaScript -->
        </div>
    </div>

    <p class="text-center text-white text-xs mt-5 font-organetto">Pastikan jadwal sesuai ketersediaan Anda</p>
  </div>
</div>
@endsection

@section('script')
<script>
    var schedules = JSON.parse(@json($schedules));
    var interviewMode = 1;
    var tanggalSelect = document.getElementById('tanggal_choice');
    var jamSelect = document.getElementById('jam_choice');

    // Listen to interview mode change
    document.querySelectorAll('input[name="interview_mode"]').forEach(radio => {
        radio.addEventListener('change', function() {
            interviewMode = this.value;
            console.log(interviewMode);
            loadSchedules();
        });
    });

    function loadSchedules() {
        // Reset dropdowns
        tanggalSelect.innerHTML = '<option class="bg-purple-950" selected disabled hidden value="">Pilih Tanggal</option>';
        jamSelect.innerHTML = '<option class="bg-purple-950" selected disabled hidden value="">Pilih Jam</option>';
        jamSelect.disabled = true;

        // Filter schedules berdasarkan mode
        var filteredSchedules = schedules.filter(sch => sch.isOnline == interviewMode);
        var currentDateTime = new Date();
        var uniqueDates = new Set();

        filteredSchedules.forEach(sch => {
            let date = new Date(sch.tanggal);

            if (date >= currentDateTime) {
                // Format hari dan tanggal
                let dayOptions = { weekday: 'long' };
                let dateOptions = { month: 'long', day: 'numeric' };
                let formattedDay = new Intl.DateTimeFormat('id-ID', dayOptions).format(date);
                let formattedDate = new Intl.DateTimeFormat('id-ID', dateOptions).format(date);

                let optionText = `${formattedDay}, ${formattedDate}`; // text: Hari, Tanggal

                if (!uniqueDates.has(sch.tanggal)) {
                    uniqueDates.add(sch.tanggal);
                    tanggalSelect.innerHTML += `<option class="bg-purple-950" value='${sch.tanggal}'>${optionText}</option>`;
                }
            }
        });
    }

    tanggalSelect.addEventListener('change', function() {
        jamSelect.disabled = false;
        jamSelect.innerHTML = '<option class="bg-purple-950" selected disabled hidden value="">Pilih Jam</option>';
        
        var selectedDate = this.value;
        var currentTime = new Date();
        var twoHoursFromNow = new Date(currentTime.getTime() + 2 * 60 * 60 * 1000);
        var filteredSchedules = schedules.filter(sch => sch.isOnline == interviewMode);

        filteredSchedules.forEach(sch => {
            if (sch.tanggal === selectedDate) {
                let [hours, minutes] = sch.jam_mulai.split(':').map(Number);
                let scheduledTime = new Date(new Date(selectedDate).setHours(hours, minutes));
                
                if (scheduledTime >= twoHoursFromNow) {
                    let formattedTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
                    jamSelect.innerHTML += `<option class="bg-purple-950" value='${sch.jam_mulai}'>${formattedTime}</option>`;
                }
            }
        });
    });

    // Load initial schedules
    loadSchedules();

    // Check if interview already exists
    var interviews = JSON.parse(@json($interviews));
    console.log(interviews);
    var isExists = JSON.parse(@json($isExists));
    if (isExists) {
        document.getElementById('backToHomepage').classList.remove('hidden');
        document.getElementById('form_jadwal').classList.add('hidden');
        
        let detailsHtml = '<div class="space-y-6">';
        
        if (interviews.interview1 && Object.keys(interviews.interview1).length > 0) {
            let dateString = interviews.interview1.tanggal;
            let formattedDate = '';
            if (dateString) {
                let date = new Date(dateString);
                let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                formattedDate = new Intl.DateTimeFormat('id-ID', options).format(date);
            }
            
            let formattedTime = interviews.interview1.jam || 'N/A';
            if (formattedTime !== 'N/A') {
                let [hours, minutes] = formattedTime.split(':');
                formattedTime = `${hours}:${minutes}`;
            }

            detailsHtml += `
            <div class="bg-purple-900/30 border-2 border-purple-500/50 rounded-2xl p-8 space-y-4">
                <h3 class="font-organetto text-xl font-bold text-center text-white mb-6 uppercase tracking-wider">Detail Interview ${interviews.interview1.division}</h3>
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-organetto font-semibold text-purple-200 min-w-[140px]">Pewawancara:</span>
                        <span class="font-organetto text-white">${interviews.interview1.adminName || "N/A"}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-organetto font-semibold text-purple-200 min-w-[140px]">Mode:</span>
                        <span class="font-organetto text-white">${interviews.interview1.mode ? 'Online (Google Meet)' : 'Offline'}</span>
                    </div>
                    ${interviews.interview1.mode ? `
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-organetto font-semibold text-purple-200 min-w-[140px]">Link GMeet:</span>
                        <a href="${interviews.interview1.link_gmeet || '#'}" target="_blank" class="font-organetto text-purple-300 hover:text-purple-100 underline break-all">${interviews.interview1.link_gmeet || "N/A"}</a>
                    </div>
                    ` : `
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-organetto font-semibold text-purple-200 min-w-[140px]">Lokasi:</span>
                        <span class="font-organetto text-white">${interviews.interview1.location || "N/A"}</span>
                    </div>
                    `}
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-organetto font-semibold text-purple-200 min-w-[140px]">Hari, Tanggal:</span>
                        <span class="font-organetto text-white">${formattedDate}</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span class="font-organetto font-semibold text-purple-200 min-w-[140px]">Jam:</span>
                        <span class="font-organetto text-white">${formattedTime}</span>
                    </div>
                </div>
            </div>`;
        }
        
        detailsHtml += '</div>';
        document.getElementById('interview_details').innerHTML = detailsHtml;
        document.getElementById('interview_details').classList.remove('hidden');
    }

    $("#form_jadwal").on('submit', function(e) {
        e.preventDefault();
        document.getElementById('submitJadwal').disabled = true;

        Swal.fire({
            title: "Konfirmasi Submit",
            text: "Pastikan jadwal yang dipilih sudah benar. Data tidak dapat diubah setelah submit!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#a855f7",
            cancelButtonColor: "#e11d48",
            confirmButtonText: "Ya, Submit!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $(this)[0];
                var formData = new FormData(form);
                var method = $(this).attr('method');
                var url = $(this).attr('action');
                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: async function(response) {
                        if (response.success) {
                            await Swal.fire({
                                title: "Berhasil!",
                                text: response.message,
                                icon: "success",
                                confirmButtonColor: "#a855f7",
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
                            document.getElementById('submitJadwal').disabled = false;
                            await Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                html: response.message,
                                confirmButtonColor: "#a855f7"
                            });
                        }
                    },
                    error: async function(xhr, textStatus, errorThrown) {
                        document.getElementById('submitJadwal').disabled = false;
                        await Swal.fire({
                            title: 'Oops!',
                            text: 'Something went wrong: ' + textStatus + '-' + errorThrown,
                            icon: 'error',
                            confirmButtonColor: "#a855f7",
                            confirmButtonText: 'OK'
                        });
                    }
                })
            } else {
                document.getElementById('submitJadwal').disabled = false;
                Swal.fire({
                    title: "Dibatalkan!",
                    text: "Data tidak disubmit.",
                    icon: "info",
                    confirmButtonColor: "#a855f7",
                    confirmButtonText: "OK"
                });
            }
        });
    });
</script>
@endsection