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
            $data['division_choice1'] = Division::where('id', $applicant->division_choice1)->first()->slug;
            if ($applicant->division_choice2){
                $data['division_choice2'] = Division::where('id', $applicant->division_choice2)->first()->slug;
            }else{
                $data['division_choice2'] = null;
            }
        }

        return view('applicant.biodata', [
            'title' => $title,
            'dataMhs' => json_encode($data),
            'exists' => json_encode($isExist)
        ]);
    }

    public function storeBiodata(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|min:1',
            'nrp'  => 'required|string|size:9|unique:applicants', 
            'angkatan' => 'required|integer|digits:4',
            'prodi' => 'required|string|min:1',
            'line_id' => 'required|string|min:1',
            'no_hp' => 'required|string|min:1',
            'division_choice1' => 'required'
        ], [
            'nama_lengkap.required' => 'Name is required',
            'nrp.required' => 'NRP is required',
            'nrp.size' => 'NRP size must 9 words',
            'nrp.unique' => 'NRP must unique',
            'angkatan.digits' => 'Angkatan must in 4 digits',
            'prodi.required' => 'Program Studi is required',
            'line_id.required' => 'ID Line is required',
            'no_hp.required' => 'Whatsapp Number is required',
            'division_choice1.required' => 'Division 1 is required',
        ]);

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

        if($request->division_choice1 === $request->division_choice2){
            return response()->json(['success' => false, 'message' => 'Divisi tidak boleh sama']);
        }

        $divisionId1 = Division::where('slug', $request->division_choice1)->first()->id;
        if($request->division_choice2){
            $divisionId2 = Division::where('slug', $request->division_choice2)->first()->id;
        }else{
            $divisionId2 = $request->division_choice2;
        };
        
        Applicant::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nrp'  => $request->nrp, 
            'angkatan' => $request->angkatan,
            'prodi' => $request->prodi,
            'line_id' => $request->line_id,
            'no_hp' => $request->no_hp,
            'division_choice1' => $divisionId1,
            'division_choice2' => $divisionId2
        ]);
        return response()->json(['success' => true, 'message' => 'Data berhasil di Submit']);
    }

    public function motivasiIndex()
    {
        $title = 'Kompetensi dan Komitmen Pribadi';
        $data = [];
        $nrp = Session::get('nrp');
        $isExists = Applicant::where('nrp', $nrp)->whereHas('motivation')->exists();
        if($isExists){
            $motivation = Applicant::with('motivation')->where('nrp', $nrp)->first();
            $data['motivasi'] = $motivation->motivation->motivasi;
            $data['komitmen'] = $motivation->motivation->komitmen;
            $data['kelebihan'] = $motivation->motivation->kelebihan;
            $data['kekurangan'] = $motivation->motivation->kekurangan;
            $data['pengalaman'] = $motivation->motivation->pengalaman;
        }

        return view('applicant.motivasi', [
            'title' => $title,
            'data' => json_encode($data),
            'isExists' => json_encode($isExists)
        ]);
    }

    public function storeMotivasi(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'motivasi' => 'required|string|min:1',
            'komitmen' => 'required|string|min:1',
            'kelebihan' => 'required|string|min:1',
            'kekurangan' => 'required|string|min:1',
            'pengalaman' => 'required|string|min:1'
        ], [
            'motivasi.required' => 'Motivasi is required',
            'komitmen.required' => 'Komitmen is required',
            'kelebihan.required' => 'Kelebihan is required',
            'kekurangan.required' => 'Kekurangan is required',
            'pengalaman.required' => 'Pengalaman Kepanitiaan is required'
        ]);

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

        $nrp = Session::get('nrp');
        $applicantId = Applicant::where('nrp',$nrp)->first()->id;
        Motivation::create([
            'applicant_id' => $applicantId,
            'motivasi' => $request->motivasi,
            'komitmen' => $request->komitmen,
            'kelebihan' => $request->kelebihan,
            'kekurangan' => $request->kekurangan,
            'pengalaman' => $request->pengalaman,
        ]);
        return response()->json(['success' => true, 'message' => 'Data berhasil di Submit']);
    }

    public function berkasIndex()
    {
        $title = 'Berkas';
        $nrp = Session::get('nrp');
        $data = [];
        $isExists = Applicant::where('nrp', $nrp)->whereHas('applicantFile')->exists();
        if($isExists){
            $applicant = Applicant::with('applicantFile')->where('nrp', $nrp)->first();
            $data['berkas'] = Storage::url($applicant->applicantFile->foto_diri);
            $data['portofolio'] = $applicant->applicantFile->portofolio ?? null;
        }

        return view('applicant.berkas', [
            'title' => $title,
            'data' => json_encode($data),
            'isExists' => json_encode($isExists)
        ]);
    }

    public function storeBerkas(Request $request)
    {
        $rules = [
            'berkas' => 'required|mimes:pdf|max:5120',
        ];
        $messages = [
            'berkas.required' => 'Berkas is required',
            'berkas.mimes' => 'Berkas must be .pdf',
            'berkas.max' => 'Berkas must be under 5 MB',
        ];


        $nrp = Session::get('nrp');
        $creativeId = Division::where('slug', 'creative')->first()->id;
        $isJoinCreative = Applicant::where('nrp', $nrp)->where('division_choice1', $creativeId)->exists() || Applicant::where('nrp', $nrp)->where('division_choice2', $creativeId)->exists();

        if($isJoinCreative){
            $rules['portofolio'] = 'required|url';
            $messages['portofolio.required'] = 'Portofolio is required';
            $messages['portofolio.url'] = 'Portofolio field must be a valid URL';
        }

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

        $nrp = Session::get('nrp');
        $applicantId = Applicant::where('nrp',$nrp)->first()->id;
        $requestFillable = $request->all();
        $requestFillable['applicant_id'] = $applicantId;


        // Check for and store the uploaded files
        if ($request->hasFile('berkas')) {
            $berkas = $request->file('berkas');
            $requestFillable['berkas'] = $berkas->storePubliclyAs('uploads/berkas', $nrp . '_berkas.' . $berkas->getClientOriginalExtension(), 'public');
        }

        ApplicantFile::create($requestFillable);

        return response()->json(['success' => true, 'message' => 'Data berhasil di Submit']);
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
        $isHaveDivision2 = Applicant::where('nrp', $nrp)->whereNotNull('division_choice2')->exists();
        if($isHaveDivision2){
            $rules['hari_choice2'] = 'required';
            $rules['tanggal_choice2'] = 'required';
            $rules['jam_choice2'] = 'required';
            $messages['hari_choice2.required'] = 'Pilihan Hari Divisi Kedua is required';
            $messages['tanggal_choice2.required'] = 'Pilihan Tanggal Divisi Kedua is required';
            $messages['jam_choice2.required'] = 'Pilihan Jam Divisi Kedua is required';
        };

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
        if($division2) {
            $schedulesReady = AdminSchedule::whereHas('admin', function ($query) use ($division2) {
                $query->where('division_id', $division2);
            })
            ->whereNull('applicant_id')
            ->with(['admin', 'schedule']) // Load related admin and schedule data
            ->get(); // Get all relevant schedules
            
            $dataUpdated = null;
            foreach ($schedulesReady as $scheduleReady) {
                // Check if the related schedule has matching tanggal and jam
                if ($scheduleReady->schedule->tanggal == $request->tanggal_choice2 && 
                    $scheduleReady->schedule->jam_mulai == $request->jam_choice2) {
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
            $message['hari'] = $request->hari_choice2;
            $message['tanggal'] = $request->tanggal_choice2;
            $message['jam'] = $request->jam_choice2;
            $message['link_gmeet'] = $dataUpdated->admin->link_gmeet;
            SendMail::dispatch($dataMail['applicant'], $message);
            SendMail::dispatch($dataMail['admin'], $message);
            // Mail::to($dataMail['applicant'])->send(new ScheduleNotif($message));
            // Mail::to($dataMail['admin'])->send(new ScheduleNotif($message));
        }

        return response()->json(['success' => true, 'message' => 'Jadwal berhasil di Submit']);

    }

    public function login()
    {
        return view('applicant.login');
    }
}
