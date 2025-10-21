@extends('applicant.layout')
@section('content')
<div class="background min-h-screen flex flex-col items-center justify-center px-4 py-6 sm:px-5 lg:px-6">
  <div class="w-full max-w-4xl">
    <div class="mb-6 flex justify-between items-center">
      <a href="{{ route('applicant.berkas') }}">
        <button class="px-6 py-2 border-2 border-teal-400 text-white font-bold card-glowing-border uppercase tracking-widest rounded-full text-sm sm:text-base transition-all duration-300 hover:bg-white hover:text-teal-600 hover:shadow-lg hover:shadow-teal-400/40">
          ← Back
        </button>
      </a>
      <a href="{{ route('applicant.homepage') }}" id="backToHomepage" class="hidden">
        <button class="px-6 py-2 border-2 border-teal-400 text-white font-bold card-glowing-border uppercase tracking-widest rounded-full text-sm sm:text-base transition-all duration-300 hover:bg-white hover:text-teal-600 hover:shadow-lg hover:shadow-teal-400/40">
          Back to Homepage
        </button>
      </a>
    </div>

    <x-progress-stepper :currentStep="$currentStep" />

    <h1 class="font-return-grid text-white text-2xl sm:text-4xl text-center mb-8 tracking-widest drop-shadow-[0_0_25px_rgba(45,212,191,0.7)]">
      {{ Str::upper($title); }}
    </h1>

    <div class="card-glowing-border rounded-2xl p-6 border border-teal-400/40">
      @if (isset($noSchedulesAvailable) && $noSchedulesAvailable)
        <div class="text-center text-white py-8">
            <svg class="w-16 h-16 mx-auto text-yellow-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h2 class="font-organetto text-2xl font-bold mb-2">Semua Jadwal Telah Terisi</h2>
            <p class="text-teal-200 text-base mb-4">
                Mohon maaf, saat ini semua slot jadwal interview telah penuh.
            </p>
            <p class="text-teal-200 text-base">
                Anda akan segera dihubungi oleh panitia untuk penjadwalan manual.
            </p>
            <div class="mt-6 bg-cyan-900/50 border border-teal-400/50 rounded-lg p-4">
                <p class="text-sm text-teal-300">Hubungi Contact Person jika ada pertanyaan:</p>
                <p class="font-bold text-lg text-white mt-1">LINE ID: <span class="tracking-widest">{{ $contactPersonLineId }}</span></p>
            </div>
        </div>
      @else
      <form id="form_jadwal" method="post" action="{{ route('applicant.jadwal.store') }}" class="space-y-6">
        @csrf
        <input type="hidden" name="division_group" value="{{ $divisionName }}">
        <div>
          <label class="font-organetto block text-white text-sm sm:text-base font-semibold uppercase mb-2">Mode Interview</label>
          <div class="grid grid-cols-2 gap-3">
            <label class="cursor-pointer">
              <input type="radio" name="interview_mode" value="1" class="peer sr-only" checked>
              <div class="flex items-center justify-center gap-2 px-4 py-2 border border-teal-400/50 rounded-full text-sm sm:text-base text-white peer-checked:bg-teal-500 peer-checked:shadow-[0_0_15px_rgba(45,212,191,0.5)] transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                </svg>
                <span>Online</span>
              </div>
            </label>
            <label class="cursor-pointer">
              <input type="radio" name="interview_mode" value="0" class="peer sr-only">
              <div class="flex items-center justify-center gap-2 px-4 py-2 border border-teal-400/50 rounded-full text-sm sm:text-base text-white peer-checked:bg-teal-500 peer-checked:shadow-[0_0_15px_rgba(45,212,191,0.5)] transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Offline</span>
              </div>
            </label>
          </div>
        </div>

        <div class="bg-cyan-900/30 border border-teal-400/30 rounded-xl p-4 text-sm sm:text-base text-teal-200">
          <p><span class="font-semibold">ID Line:</span> <a href="https://line.me/ti/p/~{{ $contactPersonLineId }}" target="_blank" class="text-white hover:underline">{{ $contactPersonLineId }}</a></p>
          <p class="text-teal-300/70 text-xs mt-1">Jika tidak ada jadwal yang sesuai, silakan hubungi ID line di atas</p>
        </div>

        @foreach (['Tanggal' => 'tanggal_choice', 'Jam' => 'jam_choice'] as $label => $id)
          <div>
            <label for="{{ $id }}" class="block mb-2 text-sm text-teal-200 font-organetto">{{ $label }}</label>
            <div class="relative">
              <select id="{{ $id }}" name="{{ $id }}" class="w-full px-4 py-3 bg-transparent border border-teal-400/50 rounded-full text-sm sm:text-base text-white focus:outline-none focus:border-teal-300 focus:shadow-[0_0_12px_rgba(45,212,191,0.4)]">
                <option class="bg-cyan-950" disabled selected hidden>Pilih {{ $label }}</option>
              </select>
            </div>
          </div>
        @endforeach

        <button type="submit" id="submitJadwal" class="w-full py-3 border-2 border-teal-400 text-white font-semibold uppercase rounded-full hover:bg-white hover:text-teal-500 transition-all">
          Submit Jadwal
        </button>
      </form>
      @endif
      <div id="interview_details" class="hidden space-y-8">
            </div>
    </div>

    <p class="text-center text-white text-xs mt-5 font-organetto">
        @if (isset($noSchedulesAvailable) && $noSchedulesAvailable)
            Terima kasih atas pengertian Anda
        @else
            Pastikan jadwal sesuai ketersediaan Anda
        @endif
    </p>
  </div>
</div>
@endsection

@section('script')
<script>
    var schedules = @json($schedules);
    var interviewMode = 1;
    var tanggalSelect = document.getElementById('tanggal_choice');
    var jamSelect = document.getElementById('jam_choice');

    document.querySelectorAll('input[name="interview_mode"]').forEach(radio => {
        radio.addEventListener('change', function() {
            interviewMode = this.value;
            loadSchedules();
        });
    });

    function loadSchedules() {
        tanggalSelect.innerHTML = '<option class="bg-cyan-950" selected disabled hidden value="">Pilih Tanggal</option>';
        jamSelect.innerHTML = '<option class="bg-cyan-950" selected disabled hidden value="">Pilih Jam</option>';
        jamSelect.disabled = true;

        var filteredSchedules = schedules.filter(sch => sch.isOnline == interviewMode);
        var currentDateTime = new Date();
        var uniqueDates = new Set();

        if (filteredSchedules.length === 0) {
            tanggalSelect.innerHTML = '<option class="bg-cyan-950" selected disabled hidden value="">Tidak ada jadwal yang tersedia</option>';
            jamSelect.innerHTML = '<option class="bg-cyan-950" selected disabled hidden value="">Tidak ada jadwal yang tersedia</option>';
            jamSelect.disabled = true;
            $('#submitJadwal').prop('disabled', true);
            return;
        }

        $('#submitJadwal').prop('disabled', false);
        filteredSchedules.forEach(sch => {
            let date = new Date(sch.tanggal);

            if (date >= currentDateTime) {
                let dayOptions = { weekday: 'long' };
                let dateOptions = { month: 'long', day: 'numeric' };
                let formattedDay = new Intl.DateTimeFormat('id-ID', dayOptions).format(date);
                let formattedDate = new Intl.DateTimeFormat('id-ID', dateOptions).format(date);
                let optionText = `${formattedDay}, ${formattedDate}`;

                if (!uniqueDates.has(sch.tanggal)) {
                    uniqueDates.add(sch.tanggal);
                    // CHANGED: Option background color
                    tanggalSelect.innerHTML += `<option class="bg-cyan-950" value='${sch.tanggal}'>${optionText}</option>`;
                }
            }
        });
    }

    tanggalSelect.addEventListener('change', function() {
        jamSelect.disabled = false;
        jamSelect.innerHTML = '<option class="bg-cyan-950" selected disabled hidden value="">Pilih Jam</option>';
        
        var selectedDate = this.value;
        var currentTime = new Date();
        var twoHoursFromNow = new Date(currentTime.getTime() + 2 * 60 * 60 * 1000);
        var filteredSchedules = schedules.filter(sch => sch.isOnline == interviewMode);

        var uniqueTimes = new Set();

        filteredSchedules.forEach(sch => {
            if (sch.tanggal === selectedDate) {
                let [hours, minutes] = sch.jam_mulai.split(':').map(Number);
                let scheduledTime = new Date(new Date(selectedDate).setHours(hours, minutes));
                
                if (scheduledTime >= twoHoursFromNow) {
                    if(!uniqueTimes.has(sch.jam_mulai)) {
                        uniqueTimes.add(sch.jam_mulai);
                        let formattedTime = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
                        jamSelect.innerHTML += `<option class="bg-cyan-950" value='${sch.jam_mulai}'>${formattedTime}</option>`;
                    }
                }
            }
        });
    });

    // Load initial schedules
    loadSchedules();

    var interviews = @json($interviews);
    var isExists = @json($isExists);
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
            <div class="bg-cyan-900/30 border-2 border-teal-400/50 rounded-2xl p-8 space-y-4">
                <h3 class="font-organetto text-xl font-bold text-center text-white mb-6 uppercase tracking-wider">Detail Interview ${interviews.interview1.division}</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-[40%_60%] gap-2">
                        <span class="font-organetto font-semibold text-teal-200 min-w-[140px] text-xs md:text-lg">Pewawancara</span>
                        <span class="font-organetto text-white text-xs md:text-lg">: ${interviews.interview1.adminName || "N/A"}</span>
                    </div>
                    <div class="grid grid-cols-[40%_60%] gap-2">
                        <span class="font-organetto font-semibold text-teal-200 min-w-[140px] text-xs md:text-lg">Mode</span>
                        <span class="font-organetto text-white text-xs md:text-lg">: ${interviews.interview1.mode ? 'Online (Google Meet)' : 'Offline'}</span>
                    </div>
                    ${interviews.interview1.mode ? `
                    <div class="grid grid-cols-[40%_60%] gap-2">
                        <span class="font-organetto font-semibold text-teal-200 min-w-[140px] text-xs md:text-lg">Link GMeet</span>
                        <span class="font-organetto text-teal-200 text-xs md:text-lg">: <a href="${interviews.interview1.link_gmeet || '#'}" target="_blank" class="underline break-all text-teal-300 hover:text-teal-100">${interviews.interview1.link_gmeet || "N/A"}</a></span>
                    </div>
                    ` : `
                    <div class="grid grid-cols-[40%_60%] gap-2">
                        <span class="font-organetto font-semibold text-teal-200 min-w-[140px] text-xs md:text-lg">Lokasi</span>
                        <span class="font-organetto text-white text-xs md:text-lg">: ${interviews.interview1.location || "N/A"}</span>
                    </div>
                    `}
                    <div class="grid grid-cols-[40%_60%] gap-2">
                        <span class="font-organetto font-semibold text-teal-200 min-w-[140px] text-xs md:text-lg">Hari, Tanggal</span>
                        <span class="font-organetto text-white text-xs md:text-lg">: ${formattedDate}</span>
                    </div>
                    <div class="grid grid-cols-[40%_60%] gap-2">
                        <span class="font-organetto font-semibold text-teal-200 min-w-[140px] text-xs md:text-lg">Jam</span>
                        <span class="font-organetto text-white text-xs md:text-lg">: ${formattedTime}</span>
                    </div>
                </div>
                <div class="mt-8 pt-6 border-t border-teal-400/30 flex flex-col sm:flex-row justify-center items-center gap-4">
                    ${interviews.interview1.id_line ? `
                    <a href="https://line.me/ti/p/~${interviews.interview1.id_line}" target="_blank" class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-3 border border-teal-400 text-teal-200 font-semibold uppercase rounded-full hover:bg-teal-500 hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zM5 10a1 1 0 11-2 0 1 1 0 012 0zm5 0a1 1 0 11-2 0 1 1 0 012 0zm5 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                        <span>Contact Person</span>
                    </a>
                    ` : ''}
                    <button id="showSopBtn" type="button" class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-3 bg-teal-500 text-white font-semibold uppercase rounded-full hover:bg-teal-600 transition-all duration-300">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm2 1a1 1 0 011-1h6a1 1 0 011 1v2a1 1 0 01-1 1H7a1 1 0 01-1-1V5z" clip-rule="evenodd"></path></svg>
                        <span>SOP Interview</span>
                    </button>
                </div>
            </div>`;
        }
        
        detailsHtml += '</div>';
        document.getElementById('interview_details').innerHTML = detailsHtml;
        document.getElementById('interview_details').classList.remove('hidden');
    }

    $(document).on('click', '#showSopBtn', function() {
        const sopContent = `
            <div class="text-left text-sm sm:text-base p-2 sm:p-4">
                <ul class="list-disc list-inside space-y-3">
                    <li>Peserta wawancara harap hadir <strong>5 menit sebelum</strong> wawancara dimulai.</li>
                    <li>Batas keterlambatan dengan izin pewawancara adalah <strong>15 menit</strong> setelah waktu wawancara dimulai.</li>
                    <li>Peserta wawancara mengenakan <strong>pakaian sopan</strong> sesuai standar universitas, minimal kaos berlengan.</li>
                    <li>Selama sesi wawancara (online), peserta wajib <strong>on camera</strong> dengan memperlihatkan, minimal, sebahu di tempat yang terang dan kondusif.</li>
                    <li>Peserta <strong>WAJIB</strong> menggunakan kata-kata yang sopan dan bertindak sopan.</li>
                    <li>Peserta <strong>DILARANG</strong> untuk makan selama proses wawancara.</li>
                    <li>Harap <strong>menghubungi pewawancara</strong> jika terdapat kendala selama berlangsungnya proses wawancara.</li>
                </ul>
            </div>
        `;
        
        Swal.fire({
            title: '<strong>SOP Interview</strong>',
            icon: 'info',
            html: sopContent,
            width: '90%',
            maxWidth: '600px',
            confirmButtonColor: "#2dd4bf",
            confirmButtonText: 'Saya Mengerti'
        });
    });

    $("#form_jadwal").on('submit', function(e) {
        e.preventDefault();
        document.getElementById('submitJadwal').disabled = true;

        Swal.fire({
            title: "Konfirmasi Submit",
            text: "Pastikan jadwal yang dipilih sudah benar. Data tidak dapat diubah setelah submit!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#2dd4bf",
            cancelButtonColor: "#e11d48",
            confirmButtonText: "Ya, Submit!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                var form = $(this)[0];
                var formData = new FormData(form);
                var method = $(this).attr('method');
                var url = $(this).attr('action');
                Swal.fire({
                    title: "Please wait...",
                    showConfirmButton: false,
                    didOpen: () => {
                        // Set custom z-index for the Swal container and backdrop
                        document.querySelector('.swal2-container').style.zIndex = '2002'; // Adjust z-index as needed
                        document.querySelector('.swal2-backdrop-show').style.zIndex = '2001'; // Adjust backdrop z-index if needed
                        Swal.showLoading();
                    }
                })
                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: async function(response) {
                        await Swal.close();
                        if (response.success) {
                            await Swal.fire({
                                title: "Berhasil!",
                                text: response.message,
                                icon: "success",
                                confirmButtonColor: "#2dd4bf",
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
                                confirmButtonColor: "#2dd4bf"
                            });
                        }
                    },
                    error: async function(xhr, textStatus, errorThrown) {
                        await Swal.close();
                        document.getElementById('submitJadwal').disabled = false;
                        await Swal.fire({
                            title: 'Oops!',
                            text: 'Something went wrong: ' + textStatus + '-' + errorThrown,
                            icon: 'error',
                            confirmButtonColor: "#2dd4bf",
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
                    confirmButtonColor: "#2dd4bf",
                    confirmButtonText: "OK"
                });
            }
        });
    });
</script>
@endsection