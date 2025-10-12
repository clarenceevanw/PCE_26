@extends('admin.layout')

@section('style')
@endsection

@section('content')
    <div class="container mx-auto mt-10 p-5 bg-white rounded-lg shadow-md max-w-screen-xl">
        <!-- Biodata Section -->
        <section class="mb-8">
            <h2 class="text-xl font-semibold mb-4">Biodata</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="biodata_section">
                <div class="grid grid-cols-[40%_60%] gap-4">
                    <strong class="w-3/5">Name</strong>
                    <div id="applicant-name">: </div>
                </div>
                <div class="grid grid-cols-[40%_60%] gap-4">
                    <strong class="w-3/5">NRP</strong>
                    <div id="applicant-nrp">: </div>
                </div>
                <div class="grid grid-cols-[40%_60%] gap-4">
                    <strong class="w-3/5">Angkatan</strong>
                    <div id="applicant-angkatan">: </div>
                </div>
                <div class="grid grid-cols-[40%_60%] gap-4">
                    <strong class="w-3/5">Program Studi</strong>
                    <div id="applicant-prodi">: </div>
                </div>
                <div class="grid grid-cols-[40%_60%] gap-4">
                    <strong class="w-3/5">ID Line</strong>
                    <div id="applicant-idLine">: </div>
                </div>
                <div class="grid grid-cols-[40%_60%] gap-4">
                    <strong class="w-3/5">No. HP</strong>
                    <div id="applicant-no_hp">: </div>
                </div>
                <div class="grid grid-cols-[40%_60%] gap-4">
                    <strong class="w-3/5">Division 1</strong>
                    <div id="applicant-divisi1">: </div>
                </div>
                <div class="grid grid-cols-[40%_60%] gap-4">
                    <strong class="w-3/5">Division 2</strong>
                    <div id="applicant-divisi2">: </div>
                </div>
            </div>
        </section>

        <!-- Motivation Section -->
        <section class="mb-8">
            <h2 class="text-xl font-semibold mb-2">Motivation</h2>
            <div class="grid grid-cols-1 gap-4">
                <div class="grid grid-cols-[30%_70%] gap-4">
                    <strong class="w-3/5">Motivasi</strong>
                    <div id="applicant-motivasi">: </div>
                </div>
                <div class="grid grid-cols-[30%_70%] gap-4">
                    <strong class="w-3/5">Komitmen</strong>
                    <div id="applicant-komitmen">: </div>
                </div>
                <div class="grid grid-cols-[30%_70%] gap-4">
                    <strong class="w-3/5">Kelebihan</strong>
                    <div id="applicant-kelebihan">: </div>
                </div>
                <div class="grid grid-cols-[30%_70%] gap-4">
                    <strong class="w-3/5">Kekurangan</strong>
                    <div id="applicant-kekurangan">: </div>
                </div>
                <div class="grid grid-cols-[30%_70%] gap-4">
                    <strong class="w-3/5">Pengalaman</strong>
                    <div id="applicant-pengalaman">: </div>
                </div>
            </div>
        </section>

        <!-- File Details Section -->
        <section>
            <h2 class="text-xl font-semibold mb-2">File Details</h2>
            <ul class="list-disc list-inside" id="list_file">
            </ul>
        </section>
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
    const data = JSON.parse(@json($data));

    document.getElementById('applicant-name').textContent += data.nama_lengkap;
    document.getElementById('applicant-nrp').textContent += data.nrp;
    document.getElementById('applicant-angkatan').textContent += data.angkatan;
    document.getElementById('applicant-prodi').textContent += data.prodi;
    document.getElementById('applicant-idLine').textContent += data.line_id;
    document.getElementById('applicant-no_hp').textContent += data.no_hp;
    document.getElementById('applicant-divisi1').textContent += data.divisi1;
    document.getElementById('applicant-divisi2').textContent += data.divisi2 ?? 'None';
    document.getElementById('applicant-motivasi').textContent += data.motivasi;
    document.getElementById('applicant-kelebihan').textContent += data.kelebihan;
    document.getElementById('applicant-kekurangan').textContent += data.kekurangan;
    document.getElementById('applicant-komitmen').textContent += data.komitmen;
    document.getElementById('applicant-pengalaman').textContent += data.pengalaman;
    if(data.berkas){
        document.getElementById('list_file').innerHTML += `
            <li>
                <strong>Berkas:</strong> 
                <a id="applicant-berkas" href="${data.berkas}" class="text-blue-500 hover:underline">Click Here</a>
            </li>
        `;
    }else{
        document.getElementById('list_file').innerHTML += `
            <li>
                <strong>Berkas:</strong> 
                <span id="applicant-berkas" class="text-red-500 hover:underline">NONE</span>
            </li>
        `; 
    }
    if(data.portofolio){
        document.getElementById('list_file').innerHTML += `
            <li>
                <strong>Portofolio:</strong> 
                <a id="applicant-portofolio" href="${data.portofolio}" class="text-blue-500 hover:underline">Click Here</a>
            </li>
        `;
    }else{
        document.getElementById('list_file').innerHTML += `
            <li>
                <strong>Portofolio:</strong> 
                <span id="applicant-portofolio" class="text-red-500 hover:underline">NONE</span>
            </li>
        `; 
    }
</script>
<script>
    function openModal(event, element){
        event.preventDefault();
        let modal = document.getElementById('modal');
        let route = element.getAttribute('href');
        modal.classList.remove("hidden")
        setTimeout(()=>{
            modal.classList.add("opacity-100")
        },10)
        $('#modalTitle').text('Detail File')
        $('#modalBody').html(`
            <img src="${route}" alt="Detail Foto" class="max-w-full h-auto">
        `
        )
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