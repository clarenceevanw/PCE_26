<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Applicant;
use App\Models\ApplicantFile;
use App\Models\Division;
use App\Models\Motivation;
use App\Models\Schedule;
use App\Models\AdminSchedule;
use App\Models\Admin;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScheduleNotif;
use App\Jobs\SendMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ApplicantController extends Controller
{
    public function homepage()
    {
        return view('homepage.homepage');
    }
    public function index()
    {
        $title = 'Biodata';
        $data = [];
        $data['nrp'] = Session::get('nrp');
        $data['name'] = Session::get('name');
        $data['angkatan'] = Session::get('angkatan');

        $nrp = Session::get('nrp');
        $isExist = Applicant::where('nrp', $nrp)->exists();
        $applicant = Applicant::where('nrp', $nrp)->first();
        if($applicant){
            $data['prodi'] = $applicant->prodi;
            $data['line_id'] = $applicant->line_id;
            $data['no_hp'] = $applicant->no_hp;
            $data['ipk'] = $applicant->ipk;
            $data['jenis_kelamin'] = $applicant->jenis_kelamin;
            $data['instagram'] = $applicant->instagram;
            $data['motivasi'] = $applicant->motivasi;
            $data['komitmen'] = $applicant->komitmen;
            $data['kelebihan'] = $applicant->kelebihan;
            $data['kekurangan'] = $applicant->kekurangan;
            $data['pengalaman'] = $applicant->pengalaman;
            $data['division_choice1'] = Division::where('id', $applicant->division_choice1)->first()->slug;
            $data['division_choice2'] = Division::where('id', $applicant->division_choice2)->first()->slug;
        }

        return view('applicant.biodata', [
            'title' => $title,
            'dataMhs' => json_encode($data),
            'exists' => json_encode($isExist)
        ]);
    }

    public function storeBiodata(Request $request)
    {
        $request->merge(array_map('trim', $request->all()));

        $valid = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|min:1',
            'nrp'  => 'required|string|size:9|unique:applicants',
            'angkatan' => 'required|digits:4',
            'prodi' => 'required|string|min:1',
            'ipk' => 'required|numeric|min:0|max:4',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'line_id' => 'required|string|min:1',
            'no_hp' => ['required', 'string', 'regex:/^(?:\+62|0)[0-9]{9,13}$/'],
            'instagram' => 'required|string|min:1',
            'motivasi' => 'required|string|min:1',
            'komitmen' => 'required|string|min:1',
            'kelebihan' => 'required|string|min:1',
            'kekurangan' => 'required|string|min:1',
            'pengalaman' => 'required|string|min:1',
            'division_choice1' => 'required',
            'division_choice2' => 'required',
        ], [
            'nrp.size' => 'NRP must be exactly 9 characters',
            'no_hp.regex' => 'Whatsapp Number must start with +62 or 0',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan',
        ]);

        if ($valid->fails()) {
            $errorString = implode('<br>', $valid->errors()->all());
            return response()->json(['success' => false, 'message' => $errorString]);
        }

        $data = $valid->validated();

        if ($data['division_choice1'] === $data['division_choice2']) {
            return response()->json(['success' => false, 'message' => 'Divisi tidak boleh sama']);
        }

        $division1 = Division::where('slug', $data['division_choice1'])->first();
        $division2 = Division::where('slug', $data['division_choice2'])->first();

        try {
            Applicant::create([
                ...$data,
                'division_choice1' => $division1->id,
                'division_choice2' => $division2->id,
            ]);

            return response()->json(['success' => true, 'message' => 'Data berhasil disubmit']);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function berkasIndex()
    {
        $title = 'Berkas';
        $nrp = Session::get('nrp');
        $data = [];
        $isExists = Applicant::where('nrp', $nrp)->whereHas('applicantFile')->exists();
        if($isExists){
            $applicant = Applicant::with('applicantFile')->where('nrp', $nrp)->first();
            $data['ktm'] = $applicant->applicantFile->ktm ? Storage::url($applicant->applicantFile->ktm) : null;
            $data['transkrip'] = $applicant->applicantFile->transkrip ? Storage::url($applicant->applicantFile->transkrip) : null;
            $data['bukti_kecurangan'] = $applicant->applicantFile->bukti_kecurangan ? Storage::url($applicant->applicantFile->bukti_kecurangan) : null;
            $data['skkk'] = $applicant->applicantFile->skkk ? Storage::url($applicant->applicantFile->skkk) : null;
            $data['portofolio'] = $applicant->applicantFile->portofolio ?? null;
        }

        return view('applicant.berkas', [
            'title' => $title,
            'data' => $data,
            'isExists' => $isExists
        ]);
    }

    public function storeKtm(Request $request)
    {
        $rules = [
            'ktm' => 'required|mimes:pdf|max:5120',
        ];
        $messages = [
            'ktm.required' => 'KTM is required',
            'ktm.mimes' => 'KTM must be .pdf',
            'ktm.max' => 'KTM must be under 5 MB',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errorString = implode('<br>', $validator->errors()->all());
            return response()->json(['success' => false, 'message' => $errorString]);
        }

        $nrp = Session::get('nrp');
        $applicant = Applicant::where('nrp', $nrp)->first();

        $ktm = $request->file('ktm');
        $ktmPath = $ktm->storePubliclyAs('uploads/berkas/ktm', $nrp . '_ktm.' . $ktm->getClientOriginalExtension(), 'public');

        $applicant->applicantFile()->updateOrCreate([
            'applicant_id' => $applicant->id,
        ], [
            'ktm' => $ktmPath,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil disubmit']);
    }

    public function storeTranskrip(Request $request)
    {
        $rules = [
            'transkrip' => 'required|mimes:pdf|max:5120',
        ];
        $messages = [
            'transkrip.required' => 'Transkrip is required',
            'transkrip.mimes' => 'Transkrip must be .pdf',
            'transkrip.max' => 'Transkrip must be under 5 MB',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errorString = implode('<br>', $validator->errors()->all());
            return response()->json(['success' => false, 'message' => $errorString]);
        }

        $nrp = Session::get('nrp');
        $applicant = Applicant::where('nrp', $nrp)->first();

        $transkrip = $request->file('transkrip');
        $transkripPath = $transkrip->storePubliclyAs('uploads/berkas/transkrip', $nrp . '_transkrip.' . $transkrip->getClientOriginalExtension(), 'public');

        $applicant->applicantFile()->updateOrCreate([
            'applicant_id' => $applicant->id,
        ], [
            'transkrip' => $transkripPath,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil disubmit']);
    }

    public function storeBuktiKecurangan(Request $request)
    {
        $rules = [
            'bukti_kecurangan' => 'required|mimes:pdf|max:5120',
        ];
        $messages = [
            'bukti_kecurangan.required' => 'Bukti kecurangan is required',
            'bukti_kecurangan.mimes' => 'Bukti kecurangan must be .pdf',
            'bukti_kecurangan.max' => 'Bukti kecurangan must be under 5 MB',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errorString = implode('<br>', $validator->errors()->all());
            return response()->json(['success' => false, 'message' => $errorString]);
        }

        $nrp = Session::get('nrp');
        $applicant = Applicant::where('nrp', $nrp)->first();

        $buktiKecurangan = $request->file('bukti_kecurangan');
        $buktiKecuranganPath = $buktiKecurangan->storePubliclyAs('uploads/berkas/bukti_kecurangan', $nrp . '_bukti_kecurangan.' . $buktiKecurangan->getClientOriginalExtension(), 'public');

        $applicant->applicantFile()->updateOrCreate([
            'applicant_id' => $applicant->id,
        ], [
            'bukti_kecurangan' => $buktiKecuranganPath,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil disubmit']);
    }

    public function storeSkkk(Request $request)
    {
        $rules = [
            'skkk' => 'required|mimes:pdf|max:5120',
        ];
        $messages = [
            'skkk.required' => 'SKKK is required',
            'skkk.mimes' => 'SKKK must be .pdf',
            'skkk.max' => 'SKKK must be under 5 MB',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            $errorString = implode('<br>', $validator->errors()->all());
            return response()->json(['success' => false, 'message' => $errorString]);
        }

        $nrp = Session::get('nrp');
        $applicant = Applicant::where('nrp', $nrp)->first();

        $skkk = $request->file('skkk');
        $skkkPath = $skkk->storePubliclyAs('uploads/berkas/skkk', $nrp . '_skkk.' . $skkk->getClientOriginalExtension(), 'public');

        $applicant->applicantFile()->updateOrCreate([
            'applicant_id' => $applicant->id,
        ], [
            'skkk' => $skkkPath,
        ]);

        return response()->json(['success' => true, 'message' => 'Data berhasil disubmit']);
    }

    public function storePortofolio(Request $request)
    {
        $nrp = Session::get('nrp');
        $applicant = Applicant::where('nrp', $nrp)->first();

        if (!$applicant) {
            return response()->json(['success' => false, 'message' => 'Applicant not found.']);
        }

        $creativeId = Division::where('slug', 'creative')->first()->id;
        $isJoinCreative = 
            $applicant->division_choice1 == $creativeId || 
            $applicant->division_choice2 == $creativeId;

        // hanya validasi jika dia ikut creative
        if ($isJoinCreative) {
            $rules = [
                'portofolio' => 'required|url',
            ];
            $messages = [
                'portofolio.required' => 'Portofolio is required',
                'portofolio.url' => 'Portofolio field must be a valid URL',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $errorString = implode('<br>', $validator->errors()->all());
                return response()->json(['success' => false, 'message' => $errorString]);
            }

            $applicant->applicantFile()->updateOrCreate(
                ['applicant_id' => $applicant->id],
                ['portofolio' => $request->portofolio]
            );

            return response()->json(['success' => true, 'message' => 'Portofolio berhasil disubmit']);
        }
        //Untuk bukan creative dia hrus tetap submit
        return response()->json(['success' => true, 'message' => 'Anda bukan dari divisi creative, tidak perlu submit portofolio.']);
    }

    public function checkBerkas()
    {
        $nrp = Session::get('nrp');
        $applicant = Applicant::with('applicantFile')->where('nrp', $nrp)->first();

        if (!$applicant) {
            return response()->json(['success' => false, 'message' => 'Applicant not found']);
        }

        $file = $applicant->applicantFile;
        if (!$file) {
            return response()->json(['success' => false, 'message' => 'File belum diupload']);
        }

        $creativeId = Division::where('slug', 'creative')->first()->id;
        $isCreative = $applicant->division_choice1 == $creativeId || $applicant->division_choice2 == $creativeId;

        // daftar kolom wajib
        $requiredFiles = ['ktm', 'transkrip', 'bukti_kecurangan', 'skkk'];
        if ($isCreative) $requiredFiles[] = 'portofolio';

        // cek satu-satu
        foreach ($requiredFiles as $fileField) {
            if (empty($file->$fileField)) {
                return response()->json([
                    'success' => false,
                    'message' => "Berkas {$fileField} belum diupload"
                ]);
            }
        }

        // kalau semua sudah lengkap
        return response()->json([
            'success' => true,
            'message' => 'Semua berkas sudah lengkap, silakan lanjut ke tahap berikutnya'
        ]);
    }

    public function jadwalIndex()
    {
        $title = 'Jadwal Interview';
        $nrp = Session::get('nrp');
        $applicant = Applicant::where('nrp', $nrp)->first();
        
        if (!$applicant) {
            return redirect()->route('applicant.homepage')->with('error', 'Data applicant tidak ditemukan');
        }

        $divisionId1 = $applicant->division_choice1;
        $divisionId2 = $applicant->division_choice2;
        
        // Cek apakah sudah ada interview yang terjadwal
        $isExists = AdminSchedule::where('applicant_id', $applicant->id)->exists();
        
        $interviews = [];
        $schedules = [];
        $divisionName = '';
        
        if ($isExists) {
            // Jika sudah ada jadwal, tampilkan detail interview
            $interview = AdminSchedule::with(['admin', 'schedule'])
                ->where('applicant_id', $applicant->id)
                ->first();
                
            if ($interview) {
                $interviews['interview1'] = [
                    'division' => $applicant->division1->name && $applicant->division2->name ? $applicant->division1->name . ' & ' . $applicant->division2->name : $applicant->division1->name ?? 'N/A',
                    'adminName' => $interview->admin->anonymous_name ?? 'N/A',
                    'link_gmeet' => $interview->admin->link_gmeet ?? null,
                    'location' => $interview->admin->location ?? null,
                    'mode' => $interview->isOnline,
                    'tanggal' => $interview->schedule->tanggal ?? null,
                    'jam' => $interview->schedule->jam_mulai ?? null,
                ];
            }
        } else {
            // Logika pencarian jadwal dengan prioritas
            // 1. Coba cari jadwal dari divisi pilihan pertama
            $schedulesDiv1 = $this->getAvailableSchedules($divisionId1);
            
            if ($schedulesDiv1->isNotEmpty()) {
                // Ada jadwal tersedia di divisi 1
                $schedules = $schedulesDiv1;
                $divisionName = Division::where('id',$divisionId1)->first()->name;
            } elseif ($divisionId2) {
                // Jika divisi 1 penuh, cek divisi 2
                $schedulesDiv2 = $this->getAvailableSchedules($divisionId2);
                
                if ($schedulesDiv2->isNotEmpty()) {
                    // Ada jadwal tersedia di divisi 2
                    $schedules = $schedulesDiv2;
                    $divisionName = Division::where('id',$divisionId2)->first()->name;
                } else {
                    // Jika kedua divisi penuh, tampilkan semua jadwal yang tersedia
                    $schedules = $this->getAllAvailableSchedules();
                    $divisionName = 'Semua Divisi (Penuh - Slot Cadangan)';
                }
            } else {
                // Jika tidak ada divisi 2 dan divisi 1 penuh, tampilkan semua jadwal
                $schedules = $this->getAllAvailableSchedules();
                $divisionName = 'Semua Divisi (Penuh - Slot Cadangan)';
            }
        }
        // dd($schedules);
        return view('applicant.jadwal', [
            'title' => $title,
            'schedules' => json_encode($schedules),
            'interviews' => json_encode($interviews),
            'isExists' => json_encode($isExists),
            'divisionName' => $divisionName
        ]);
    }

    private function getAvailableSchedules($divisionId)
    {
        // [FIX] Pilih 'admin_schedules.id' dan beri alias, ini ID yang akan dipakai untuk booking.
        return AdminSchedule::select(
                'admin_schedules.id as admin_schedule_id', 
                'schedules.tanggal', 
                'schedules.jam_mulai', 
                'admin_schedules.isOnline'
            )
            ->join('schedules', 'admin_schedules.schedule_id', '=', 'schedules.id')
            ->join('admins', 'admin_schedules.admin_id', '=', 'admins.id')
            ->where('admins.division_id', $divisionId)
            ->whereNull('admin_schedules.applicant_id')
            ->where('schedules.tanggal', '>=', now()->toDateString())
            ->orderBy('schedules.tanggal', 'asc')
            ->orderBy('schedules.jam_mulai', 'asc')
            ->get();
    }

    private function getAllAvailableSchedules()
    {
        // [FIX] Lakukan hal yang sama untuk fungsi ini.
        return AdminSchedule::select(
                'admin_schedules.id as admin_schedule_id', 
                'schedules.tanggal', 
                'schedules.jam_mulai', 
                'admin_schedules.isOnline'
            )
            ->join('schedules', 'admin_schedules.schedule_id', '=', 'schedules.id')
            ->join('admins', 'admin_schedules.admin_id', '=', 'admins.id')
            ->whereNull('admin_schedules.applicant_id')
            ->where('schedules.tanggal', '>=', now()->toDateString())
            ->orderBy('schedules.tanggal', 'asc')
            ->orderBy('schedules.jam_mulai', 'asc')
            ->get();
    }

    public function storeJadwal(Request $request)
    {
        $val = Validator::make($request->all(), [
            'interview_mode' => 'required|in:0,1',
            'tanggal_choice' => 'required|exists:schedules,tanggal',
            'jam_choice' => 'required|exists:schedules,jam_mulai'
        ], [
            'interview_mode.required' => 'Mode interview harus dipilih',
            'interview_mode.in' => 'Mode interview tidak valid',
            'tanggal_choice.required' => 'Tanggal interview harus dipilih',
            'tanggal_choice.exists' => 'Tanggal interview tidak valid',
            'jam_choice.required' => 'Jam interview harus dipilih',
            'jam_choice.exists' => 'Jam interview tidak valid'
        ]);

        if ($val->fails()) {
            $errorString = implode('<br>', $val->errors()->all());
            return response()->json(['success' => false, 'message' => $errorString]);
        }

        $nrp = Session::get('nrp');
        $applicant = Applicant::where('nrp', $nrp)->first();
        
        if (!$applicant) {
            return response()->json([
                'success' => false,
                'message' => 'Data applicant tidak ditemukan'
            ], 404);
        }

        $existingSchedule = AdminSchedule::where('applicant_id', $applicant->id)->exists();
        
        if ($existingSchedule) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memilih jadwal interview sebelumnya'
            ], 400);
        }

        try {
            DB::beginTransaction();
            
            // Get schedule details
            $schedule = Schedule::where('tanggal', $request->tanggal_choice)
                ->where('jam_mulai', $request->jam_choice)
                ->first();
            
            if (!$schedule) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal tidak ditemukan'
                ], 404);
            }

            // Verify schedule is available
            $adminSchedule = AdminSchedule::where('schedule_id', $schedule->id)
                ->whereNull('applicant_id')
                ->lockForUpdate()
                ->first();
            
            if (!$adminSchedule) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal yang dipilih sudah penuh. Silakan pilih jadwal lain.'
                ], 400);
            }
            // Verify mode matches
            if ($adminSchedule->isOnline !== (int) $request->interview_mode) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Mode interview tidak sesuai dengan jadwal yang dipilih'
                ], 400);
            }

            // Assign applicant to the schedule
            $adminSchedule->applicant_id = $applicant->id;
            $adminSchedule->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Jadwal interview berhasil dipilih! Silakan cek detail jadwal Anda.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function login()
    {
        if (session('email')) {
            return redirect()->back();
        }
        return view('applicant.login');
    }
}
