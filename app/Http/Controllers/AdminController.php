<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminSchedule;
use App\Models\Schedule;
use App\Models\Admin;
use App\Models\Division;
use App\Models\Applicant;
use App\Models\ApplicantFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $nrp = Session::get('nrp');
        $admin = Admin::where('nrp', $nrp)->first();
        $schedule = AdminSchedule::with('schedule')->where('admin_id', $admin->id)->get();
        $title = 'Jadwal Interview';

        return view('admin.jadwalWawancara', [
            'title' => $title,
            'data' => json_encode($schedule)
        ]);
    }

    public function myInterviewIndex()
    {
        $nrp = Session::get('nrp');
        $admin = Admin::where('nrp', $nrp)->first();
        $data = [];
        $schedules = AdminSchedule::with('admin', 'schedule', 'applicant')
        ->join('schedules', 'admin_schedules.schedule_id', '=', 'schedules.id') // Join with schedules table
        ->where('admin_id', $admin->id)
        ->where('statusInterview', false)
        ->whereNotNull('applicant_id')
        ->orderBy('schedules.tanggal') // Order by tanggal from schedules table
        ->orderBy('schedules.jam_mulai') // Then order by jam from schedules table
        ->select('admin_schedules.*', 'schedules.tanggal', 'schedules.jam_mulai') // Select the necessary fields
        ->get();

        foreach ($schedules as $schedule){
            $try = [];
            $try['applicant_id'] = $schedule->applicant_id;
            Carbon::setLocale('id');

            // Format the date to Indonesian
            $try['date'] = Carbon::parse($schedule->schedule->tanggal)
                ->translatedFormat('l, d F Y');


            $try['time'] = Carbon::parse($schedule->schedule->jam_mulai)->format('H:i');
            $try['nrp'] = $schedule->applicant->nrp;
            $try['isOnline'] = $schedule->isOnline;
            $try['name'] = $schedule->applicant->nama_lengkap;
            $try['id_line'] = $schedule->applicant->line_id;
            $try['no_hp'] = $schedule->applicant->no_hp;

            // $applicantFile = ApplicantFile::where('applicant_id', $schedule->applicant->id)->first();
            // $try['foto_diri'] = Storage::url($applicantFile->foto_diri);
            // $try['ktm'] = Storage::url($applicantFile->ktm);
            // $try['cv'] = Storage::url($applicantFile->cv);
            // $try['transkrip'] = Storage::url($applicantFile->transkrip);
            // $try['skkk'] = Storage::url($applicantFile->skkk);
            // $try['bukti_kecurangan'] = Storage::url($applicantFile->bukti_kecurangan);
            // $try['jadwal'] = Storage::url($applicantFile->jadwal);
            // if($applicantFile->portofolio){
            //     $try['portofolio'] = Storage::url($applicantFile->portofolio);
            // }else{
            //     $try['portofolio'] = null;
            // }
            
            $data[] = $try;
        }
        $title = 'My Interview';
        // dd($data);

        return view('admin.myInterview', [
            'title' => $title,
            'datas' => json_encode($data)
        ]);
    }

    public function allInterviewIndex()
    {
        $nrp = Session::get('nrp');
        $admin = Admin::where('nrp', $nrp)->first();
        $data = [];
        $schedules = AdminSchedule::with('admin', 'schedule', 'applicant')
        ->join('schedules', 'admin_schedules.schedule_id', '=', 'schedules.id')
        ->whereNotNull('applicant_id')
        ->orderBy('schedules.tanggal') // Order by tanggal from schedules table
        ->orderBy('schedules.jam_mulai') // Then order by jam from schedules table
        ->select('admin_schedules.*', 'schedules.tanggal', 'schedules.jam_mulai') // Select the necessary fields
        ->get();


        foreach ($schedules as $schedule){
            $try = [];
            $try['applicant_id'] = $schedule->applicant_id;
            Carbon::setLocale('id');

            // Format the date to Indonesian
            $try['date'] = Carbon::parse($schedule->schedule->tanggal)
                ->translatedFormat('l, d F Y');


            $try['time'] = Carbon::parse($schedule->schedule->jam_mulai)->format('H:i');
            $try['name'] = $schedule->applicant->nama_lengkap;
            $try['adminName'] = $schedule->admin->name;
            $try['divisi'] = Division::where('id', $schedule->admin->division_id)->first()->name;
            $try['statusInterview'] = $schedule->statusInterview ? 'Selesai' : 'Pending';
            $try['link_hasil'] = $schedule->link_hasil ?? null;
            $data[] = $try;
        }
        $title = 'All Interview';

        return view('admin.allInterview', [
            'title' => $title,
            'datas' => json_encode($data)
        ]);
    }

    public function storeHasil(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'link_hasil' => 'required|url',
        ], [
            'link_hasil.required' => 'Link hasil is required',
            'link_hasil.url' => 'Link must be a valid url',
        ]);
        if ($valid->fails()) {
            $errors = $valid->errors()->toArray();
    
            // Flatten the error messages into a single string
            $errorMessages = [];
            foreach ($errors as $messages) {
                $errorMessages = array_merge($errorMessages, $messages);
            }
            $errorString = implode('\n', $errorMessages); // Join messages with line breaks

            return response()->json(['success' => false, 'message' => $errorString]);
        }
        $nrp = Session::get('nrp');
        $nrpApplicant = $request->nrp;
        $admin = Admin::where('nrp', $nrp)->first();
        $applicant = Applicant::where('nrp', $nrpApplicant)->first();
        AdminSchedule::where('admin_id', $admin->id)->where('applicant_id', $applicant->id)->update([
            'link_hasil' => $request->link_hasil,
            'statusInterview' => true
        ]);
        return response()->json(['success' => true, 'message' => 'Link berhasil di submit'], 201);
    }

    public function accApplicantIndex()
    {
        $applicants = Applicant::whereHas('admin_schedule', function ($query) {
            $query->where('statusInterview', 1);
        })
        ->orderBy('nama_lengkap', 'asc')
        ->get();
        $data = [];
        foreach ($applicants as $applicant){
            $try= [];
            $try['id'] = $applicant->id;
            $try['nrp'] = $applicant->nrp;
            $try['name'] = $applicant->nama_lengkap;
            $try['divisi1'] = Division::where('id', $applicant->division_choice1)->first()->name;
            $try['divisi2'] = Division::where('id', $applicant->division_choice2)->first()->name ?? null;

            $divisionId = $applicant->division_choice1;
            $schedule = AdminSchedule::with('admin', 'applicant')->where('applicant_id', $applicant->id)
            ->whereHas('admin', function ($query) use ($divisionId) {
                $query->where('division_id', $divisionId);
            })
            ->first();
            $try['result1'] = $schedule->link_hasil ?? null;
            $try['status1'] = $schedule->statusTerima ?? null;

            $divisionId = $applicant->division_choice2;
            $schedule = AdminSchedule::with('admin', 'applicant')->where('applicant_id', $applicant->id)
            ->whereHas('admin', function ($query) use ($divisionId) {
                $query->where('division_id', $divisionId);
            })
            ->first() ?? null;
            $try['result2'] = $schedule->link_hasil ?? null;
            $try['status2'] = $schedule->statusTerima ?? null;
            $data[] = $try;
        }
        
        $title = 'Accept or Reject Applicant';

        return view('admin.tolakTerima', [
            'title' => $title,
            'datas' => json_encode($data)
        ]);
    }

    public function accApplicantAction(Request $request)
    {
        $divisionId = Division::where('name', $request->division_name)->first()->id;
        if($divisionId != Session::get('division_id') && Session::get('division_slug')!='bph'){
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki hak'], 201);
        }
        AdminSchedule::with('admin')
        ->where('applicant_id', $request->applicant_id)
        ->whereHas('admin', function($query) use ($divisionId) {
            $query->where('division_id', $divisionId);
        })
        ->update([
            'statusTerima' => $request->isAccepted,
        ]);
        return response()->json(['success' => true, 'message' => 'Data berhasil diubah'], 201);
    }

    public function allApplicantIndex()
    {
        $applicants = Applicant::orderBy('nama_lengkap','asc')->get();
        $data = [];
        foreach ($applicants as $applicant){
            $try= [];
            $try['id'] = $applicant->id;
            $try['nrp'] = $applicant->nrp;
            $try['name'] = $applicant->nama_lengkap;
            $try['divisi1'] = Division::where('id', $applicant->division_choice1)->first()->name;
            $try['divisi2'] = Division::where('id', $applicant->division_choice2)->first()->name ?? null;

            $divisionId = $applicant->division_choice1;
            $schedule = AdminSchedule::with('admin', 'applicant')->where('applicant_id', $applicant->id)
            ->whereHas('admin', function ($query) use ($divisionId) {
                $query->where('division_id', $divisionId);
            })
            ->first();
            $try['result1'] = $schedule->link_hasil ?? null;
            $try['status1'] = $schedule->statusTerima ?? null;

            $divisionId = $applicant->division_choice2;
            $schedule = AdminSchedule::with('admin', 'applicant')->where('applicant_id', $applicant->id)
            ->whereHas('admin', function ($query) use ($divisionId) {
                $query->where('division_id', $divisionId);
            })
            ->first() ?? null;
            $try['result2'] = $schedule->link_hasil ?? null;
            $try['status2'] = $schedule->statusTerima ?? null;
            $data[] = $try;
        }
        
        $title = 'All Applicant';

        return view('admin.allApplicant', [
            'title' => $title,
            'datas' => json_encode($data)
        ]);
    }

    public function applicantDetailIndex($applicantId){
        $applicant = Applicant::with('division1', 'division2', 'motivation', 'applicantFile')->where('id', $applicantId)->first();
        $data = [];
        if($applicant){
            $data['nama_lengkap'] = $applicant->nama_lengkap;
            $data['nrp'] = $applicant->nrp;
            $data['angkatan'] = $applicant->angkatan;
            $data['prodi'] = $applicant->prodi;
            $data['line_id'] = $applicant->line_id;
            $data['no_hp'] = $applicant->no_hp;
            $data['divisi1'] = $applicant->division1->name;
            $data['divisi2'] = $applicant->division2->name ?? 'None';
            $data['motivasi'] = $applicant->motivation->motivasi ?? 'None';
            $data['komitmen'] = $applicant->motivation->komitmen ?? 'None';
            $data['kelebihan'] = $applicant->motivation->kelebihan ?? 'None';
            $data['kekurangan'] = $applicant->motivation->kekurangan ?? 'None';
            $data['pengalaman'] = $applicant->motivation->pengalaman ?? 'None';
            if ($applicant->applicantFile->berkas ?? null){
                $data['berkas'] = Storage::url($applicant->applicantFile->berkas);
            }
            $data['portofolio'] = $applicant->applicantFile->portofolio ?? null;
        }
        $title = "Detail Applicant";

        return view('admin.detailApplicant', [
            'title' => $title,
            'data' => json_encode($data)
        ]);
    }

    public function login()
    {
        return view('admin.login');
    }
}
