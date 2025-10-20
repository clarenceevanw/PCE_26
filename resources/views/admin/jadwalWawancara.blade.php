@extends('admin.layout')

@section('style')
    <style>
        .slot {
            width: 50px;
            height: 50px;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid #ccc;
        }
        .green {
            background-color: #4CAF50;
        }
        .red {
            background-color: #f44336;
        }
        .orange{
            background-color: #fada5a;
        }
        .transparent {
            background-color: transparent; /* Tidak ada warna (putih) */
        }
        .slot.locked {
            cursor: not-allowed;
            opacity: 0.6;
            background-image: repeating-linear-gradient(
                45deg,
                rgba(0,0,0,0.2),
                rgba(0,0,0,0.2) 5px,
                transparent 5px,
                transparent 10px
            );
        }
        </style>
@endsection

@section('content')
<div class="p-10">
    
    <div class="flex flex-col lg:flex-row justify-between items-center">
        <div>
            <h2 class="text-xl mb-4">Jadwal</h2>
            <h1 class="font-organetto block mb-2 text-md font-medium text-gray-800 mt-4">Notes: Jadwal hanya bisa diubah ketika tidak ada interview</h1>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <div class="flex gap-2">
                <div class="w-10 h-6 opacity-[0.6]" 
                style="background-image: repeating-linear-gradient(
                45deg,
                rgba(0,0,0,0.2),
                rgba(0,0,0,0.2) 5px,
                transparent 5px,
                transparent 10px
            );"
            ></div>
                <span>Interview</span>
            </div>
            <div class="flex gap-2">
                <div class="w-10 h-6 bg-red-500"></div>
                <span>Tidak bisa</span>
            </div>
            <div class="flex gap-2">
                <div class="w-10 h-6 bg-[#fada5a]"></div>
                <span>Online</span>
            </div>
            <div class="flex gap-2">
                <div class="w-10 h-6 bg-green-500"></div>
                <span>Offline</span>
            </div>
        </div>
    </div>
    <form id="scheduleForm" method="POST" action="{{ route('admin.storeJadwal') }}">
        @csrf
        <div class="overflow-auto p-4">
            <table class="table-auto border-collapse border border-gray-400">
                <thead>
                    <tr>
                        <th class="border px-4 py-2">Jam/Hari</th>
                        <!-- Looping untuk menampilkan tanggal (misal dari 4-18 Oktober) -->
                        @for ($i = 23; $i <= 31; $i++)
                            <th class="border px-4 py-2">{{ $i }} Oktober</th>
                        @endfor
                        @for ($i = 1; $i <= 4; $i++)
                            <th class="border px-4 py-2">{{ $i }} November</th>
                        @endfor
                    </tr>
                </thead>
                <tbody>
                    <!-- Looping untuk menampilkan jam dari 10.00 sampai 19.00 -->
                    @for ($hour = 7; $hour <= 20; $hour++)
                    <tr>
                        <td class="border px-4 py-2">{{ $hour }}:30</td>
                        @for ($i = 23; $i <= 31; $i++)
                        <td 
                            class="slot border" 
                            data-date="{{ '2025-10-' . str_pad($i, 2, '0', STR_PAD_LEFT) }}" 
                            data-hour="{{ sprintf('%02d', $hour) }}" 
                            id="slot-{{ $i }}-{{ $hour }}"
                            onclick="toggleSlot(this)">
                        </td>
                        @endfor
                         @for ($i = 1; $i <= 4; $i++)
                        <td 
                            class="slot border" 
                            data-date="{{ '2025-11-' . str_pad($i, 2, '0', STR_PAD_LEFT) }}" 
                            data-hour="{{ sprintf('%02d', $hour) }}" 
                            id="slot-{{ $i }}-{{ $hour }}"
                            onclick="toggleSlot(this)">
                        </td>
                        @endfor
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
        
        <input type="hidden" id="selectedSlots" name="selectedSlots" value="">
        <button id="saveButton" type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg">Save</button>
        <button id="updateButton" type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg hidden">Update</button>
    </form>
</div>
@endsection

@section('script')
<script>
    const datas = JSON.parse(@json($data));
    const isUpdateMode = datas.length > 0;

    document.addEventListener('DOMContentLoaded', function() {
        if (isUpdateMode) {
            initializeUpdateMode();
        }
    });

    function initializeUpdateMode() {
        document.getElementById("saveButton").style.display = "none";
        document.getElementById('updateButton').classList.remove('hidden');
        
        const allSlots = document.querySelectorAll('.slot');
        allSlots.forEach(slot => slot.classList.add('red'));

        datas.forEach(data => {
            const timeParts = data.schedule.jam_mulai.split(':');
            const hour = timeParts[0];
            const element = document.querySelector(`[data-date="${data.schedule.tanggal}"][data-hour="${hour}"]`);
            
            if (element) {
                element.classList.remove('red');
                element.classList.add(data.isOnline ? 'orange' : 'green');

                if (data.isBooked) {
                    element.classList.add('locked');
                    element.onclick = null;
                }
            }
        });
    }

    function toggleSlot(cell) {
        if (cell.classList.contains('green')) {
            cell.classList.remove('green');
            cell.classList.add('orange');
        } else if (cell.classList.contains('orange')) {
            cell.classList.remove('orange');
            cell.classList.add('red');
        } else if (cell.classList.contains('red')) {
            cell.classList.remove('red');
            cell.classList.add('green');
        } else {
            cell.classList.add('green');
        }

        if (!isUpdateMode) {
            updateSelectedSlots();
        }
    }

    function updateSelectedSlots() {
        let selected = [];
        const greenCells = document.querySelectorAll('.slot.green');
        const orangeCells = document.querySelectorAll('.slot.orange');

        greenCells.forEach(cell => {
            selected.push({
                date: cell.getAttribute('data-date'),
                hour: cell.getAttribute('data-hour'),
                isOnline: false
            });
        });

        orangeCells.forEach(cell => {
            selected.push({
                date: cell.getAttribute('data-date'),
                hour: cell.getAttribute('data-hour'),
                isOnline: true
            });
        });
        
        document.getElementById('selectedSlots').value = JSON.stringify(selected);
        console.log("Selected slots updated!");
    }
</script>
<script>
    $("#scheduleForm").on('submit', function(e){
        e.preventDefault();
        if(isUpdateMode) {
            console.log("Update mode: Collecting final data before submit...");
            updateSelectedSlots();
            console.log(document.getElementById('selectedSlots').value);
        }

        Swal.fire({
            title: "Are you sure want to save Schedule?",
            text: "Once you save data, the data cannot be changed!",
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
                Swal.fire({
                    title: 'Loading...',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
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
                                text: response.message,
                            });
                        }
                    },
                    error: async function(xhr, textStatus, errorThrown) {
                        await Swal.close();
                        let message = 'Something went wrong.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        } else if (xhr.responseText) {
                            message = xhr.responseText;
                        }
                        await Swal.fire({
                            title: 'Oops!',
                            text: message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
            } else {
                Swal.fire({
                    title: "Cancelled!",
                    text: "Your data was not submitted.",
                    icon: "info",
                    confirmButtonText: "OK"
                });
            }
        });
    })
</script>
@endsection