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
        $title = 'Jadwal';
        $nrp = Session::get('nrp');
        $divisionId1 = Applicant::where('nrp', $nrp)->first()->division_choice1;
        $schedules1 = Schedule::select('tanggal', 'jam_mulai')
        ->whereIn('id', function($query) use ($divisionId1) {
            $query->select('schedule_id')
                  ->from('admin_schedules')
                  ->where('applicant_id', null)
                  ->whereIn('admin_id', function($subQuery) use ($divisionId1) {
                      $subQuery->select('id')
                                ->from('admins')
                                ->where('division_id', $divisionId1);
                  });
        })->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc')->get();


        $divisionId2 = Applicant::where('nrp', $nrp)->first()->division_choice2 ?? null;
        if($divisionId2){
            $schedules2 = Schedule::select('tanggal', 'jam_mulai')
            ->whereIn('id', function($query) use ($divisionId2) {
                $query->select('schedule_id')
                    ->from('admin_schedules')
                    ->where('applicant_id', null)
                    ->whereIn('admin_id', function($subQuery) use ($divisionId2) {
                        $subQuery->select('id')
                                    ->from('admins')
                                    ->where('division_id', $divisionId2);
                    });
            })->orderBy('tanggal', 'asc')->orderBy('jam_mulai', 'asc')->get();
        }else{
            $schedules2 = null;
        }

        $schedules = [];
        $schedules['division1'] = $schedules1;
        $schedules['division2'] = $schedules2;

        $interviews = [];
        $interview1 = [];
        $interview2 = [];

        $applicantId = Applicant::where('nrp', $nrp)->first()->id;
        $isExists = AdminSchedule::whereHas('admin', function ($query) use ($divisionId1) {
            $query->where('division_id', $divisionId1);
        })
        ->where('applicant_id', $applicantId)
        ->exists();

        if($isExists){
            $interviewSched = AdminSchedule::whereHas('admin', function ($query) use ($divisionId1) {
                $query->where('division_id', $divisionId1);
            })
            ->where('applicant_id', $applicantId)
            ->first();
            if ($interviewSched) {
                $interview1['adminName'] = $interviewSched->admin->anonymous_name; // Access admin name
                $interview1['link_gmeet'] = $interviewSched->admin->link_gmeet; // Access admin id_line
                $interview1['tanggal'] = $interviewSched->schedule->tanggal; // Access tanggal
                $interview1['jam'] = $interviewSched->schedule->jam_mulai; // Access jam
            }

            //jadwal interview2
            $interviewSched = AdminSchedule::whereHas('admin', function ($query) use ($divisionId2) {
                $query->where('division_id', $divisionId2);
            })
            ->where('applicant_id', $applicantId)
            ->first();
            if ($interviewSched) {
                $interview2['adminName'] = $interviewSched->admin->anonymous_name; // Access admin name
                $interview2['link_gmeet'] = $interviewSched->admin->link_gmeet; // Access admin id_line
                $interview2['tanggal'] = $interviewSched->schedule->tanggal; // Access tanggal
                $interview2['jam'] = $interviewSched->schedule->jam_mulai; // Access jam
            }

            $interviews['interview1'] = $interview1;
            $interviews['interview2'] = $interview2;
        };

        return view('applicant.jadwal', [
            'title' => $title,
            'schedules' => json_encode($schedules),
            'interviews' => json_encode($interviews),
            'isExists' => json_encode($isExists)
        ]);
    }

    public function storeJadwal(Request $request)
    {
        $rules = [
            'hari_choice1' => 'required',
            'tanggal_choice1' => 'required',
            'jam_choice1' => 'required',
        ];
        $messages = [
            'hari_choice1.required' => 'Pilihan Hari Divisi Pertama is required',
            'tanggal_choice1.required' => 'Pilihan Tanggal Divisi Pertama is required',
            'jam_choice1.required' => 'Pilihan Jam Divisi Pertama is required',
        ];

        $nrp = Session::get('nrp');
        $applicantId = Applicant::where('nrp', $nrp)->first()->id;
        // $isHaveDivision2 = Applicant::where('nrp', $nrp)->whereNotNull('division_choice2')->exists();
        // if($isHaveDivision2){
        //     $rules['hari_choice2'] = 'required';
        //     $rules['tanggal_choice2'] = 'required';
        //     $rules['jam_choice2'] = 'required';
        //     $messages['hari_choice2.required'] = 'Pilihan Hari Divisi Kedua is required';
        //     $messages['tanggal_choice2.required'] = 'Pilihan Tanggal Divisi Kedua is required';
        //     $messages['jam_choice2.required'] = 'Pilihan Jam Divisi Kedua is required';
        // };

        $valid = Validator::make($request->all(), $rules, $messages);
        if ($valid->fails()) {
            $errors = $valid->errors()->toArray();
    
            // Flatten the error messages into a single string
            $errorMessages = [];
            foreach ($errors as $messages) {
                $errorMessages = array_merge($errorMessages, $messages);
            }
            $errorString = implode('<br>', $errorMessages); // Join messages with line breaks

            return response()->json(['success' => false, 'message' => $errorString]);
        }

        
        if (($request->tanggal_choice1 === $request->tanggal_choice2) && ($request->jam_choice1 === $request->jam_choice2)) {
            return response()->json(['success' => false, 'message' => 'Jadwal tidak boleh sama']);
        }

        $division1 = Applicant::where('nrp', $nrp)->first()->division_choice1;
        $division2 = Applicant::where('nrp', $nrp)->first()->division_choice2;

        //pair jadwal1
        $schedulesReady = AdminSchedule::whereHas('admin', function ($query) use ($division1) {
            $query->where('division_id', $division1);
        })
        ->whereNull('applicant_id')
        ->with(['admin', 'schedule']) // Load related admin and schedule data
        ->get(); // Get all relevant schedules
        $dataUpdated = null;
        foreach ($schedulesReady as $scheduleReady) {
            // Check if the related schedule has matching tanggal and jam
            if ($scheduleReady->schedule->tanggal == $request->tanggal_choice1 && 
                $scheduleReady->schedule->jam_mulai == $request->jam_choice1) {
                // Update the applicant_id if the tanggal and jam match
                
                AdminSchedule::where('id', $scheduleReady->id)->update([
                    'applicant_id' => $applicantId,
                ]);
                $dataUpdated = $scheduleReady;
                break;
            }
        }
        $dataMail = [];
        $dataMail['applicant'] = Session::get('email');
        $dataMail['admin'] = $dataUpdated->admin->nrp . '@john.petra.ac.id';
        $message = [];
        $message['hari'] = $request->hari_choice1;
        $message['tanggal'] = $request->tanggal_choice1;
        $message['jam'] = $request->jam_choice1;
        $message['link_gmeet'] = $dataUpdated->admin->link_gmeet;
        SendMail::dispatch($dataMail['applicant'], $message);
        SendMail::dispatch($dataMail['admin'], $message);
        // Mail::to($dataMail['applicant'])->send(new ScheduleNotif($message));
        // Mail::to($dataMail['admin'])->send(new ScheduleNotif($message));



        //pair jadwal2
        // if($division2) {
        //     $schedulesReady = AdminSchedule::whereHas('admin', function ($query) use ($division2) {
        //         $query->where('division_id', $division2);
        //     })
        //     ->whereNull('applicant_id')
        //     ->with(['admin', 'schedule']) // Load related admin and schedule data
        //     ->get(); // Get all relevant schedules
            
        //     $dataUpdated = null;
        //     foreach ($schedulesReady as $scheduleReady) {
        //         // Check if the related schedule has matching tanggal and jam
        //         if ($scheduleReady->schedule->tanggal == $request->tanggal_choice2 && 
        //             $scheduleReady->schedule->jam_mulai == $request->jam_choice2) {
        //             // Update the applicant_id if the tanggal and jam match
        //             AdminSchedule::where('id', $scheduleReady->id)->update([
        //                 'applicant_id' => $applicantId,
        //             ]);
        //             $dataUpdated = $scheduleReady;
        //             break;
        //         }
        //     }
        //     $dataMail = [];
        //     $dataMail['applicant'] = Session::get('email');
        //     $dataMail['admin'] = $dataUpdated->admin->nrp . '@john.petra.ac.id';
        //     $message = [];
        //     $message['hari'] = $request->hari_choice2;
        //     $message['tanggal'] = $request->tanggal_choice2;
        //     $message['jam'] = $request->jam_choice2;
        //     $message['link_gmeet'] = $dataUpdated->admin->link_gmeet;
        //     SendMail::dispatch($dataMail['applicant'], $message);
        //     SendMail::dispatch($dataMail['admin'], $message);
        //     // Mail::to($dataMail['applicant'])->send(new ScheduleNotif($message));
        //     // Mail::to($dataMail['admin'])->send(new ScheduleNotif($message));
        // }

        return response()->json(['success' => true, 'message' => 'Jadwal berhasil di Submit']);

    }

    public function login()
    {
        if (session('email')) {
            return redirect()->back();
        }
        return view('applicant.login');
    }
}
