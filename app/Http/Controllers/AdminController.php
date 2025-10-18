<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicantDetailResource;
use Illuminate\Http\Request;
use App\Models\AdminSchedule;
use App\Models\Schedule;
use App\Models\Admin;
use App\Models\Division;
use App\Models\Applicant;
use App\Models\ApplicantFile;
use App\Models\InterviewResult;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
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

        $dataForView = $schedule->map(function ($adminSchedule) {
            return [
                'schedule' => $adminSchedule->schedule,
                'isOnline' => $adminSchedule->isOnline,
                'isBooked' => $adminSchedule->applicant_id !== null, 
            ];
        });

        return view('admin.jadwalWawancara', [
            'title' => $title,
            'data' => json_encode($dataForView)
        ]);
    }

    public function myInterviewIndex()
    {
        $nrp = Session::get('nrp');
        $admin = Admin::where('nrp', $nrp)->first();
        $data = [];
        $schedules = AdminSchedule::with('admin', 'schedule', 'applicant', 'interviewResult')
            ->join('schedules', 'admin_schedules.schedule_id', '=', 'schedules.id')
            ->where('admin_id', $admin->id)
            ->whereNotNull('applicant_id')
            ->orderBy('schedules.tanggal')
            ->orderBy('schedules.jam_mulai')
            ->select('admin_schedules.*', 'schedules.tanggal', 'schedules.jam_mulai')
            ->get();

        foreach ($schedules as $schedule) {
            $try = [];
            // ... (semua kode $try['applicant_id'], $try['date'], dll. tetap sama) ...
            $try['applicant_id'] = $schedule->applicant_id;
            Carbon::setLocale('id');
            $try['date'] = Carbon::parse($schedule->schedule->tanggal)->translatedFormat('l, d F Y');
            $try['time'] = Carbon::parse($schedule->schedule->jam_mulai)->format('H:i');
            $try['nrp'] = $schedule->applicant->nrp;
            $try['isOnline'] = $schedule->isOnline;
            $try['name'] = $schedule->applicant->nama_lengkap;
            $try['id_line'] = $schedule->applicant->line_id;
            $try['no_hp'] = $schedule->applicant->no_hp;
            $try['status_interview'] = $schedule->statusInterview;

            $try['link_hasil_result1'] = null;
            $try['link_hasil_result2'] = null;

            $choice1_id = $schedule->applicant->division_choice1;
            $choice2_id = $schedule->applicant->division_choice2;

            foreach ($schedule->interviewResult as $result) {

                if ($result->division_id == $choice1_id) {
                    $try['link_hasil_result1'] = $result->link_hasil;
                }

                if ($choice2_id && $result->division_id == $choice2_id) {
                    $try['link_hasil_result2'] = $result->link_hasil;
                }
            }
            $data[] = $try;
        }
        
        $title = 'My Interview';
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
        $applicants = Applicant::with([
            'division1', 
            'division2', 
            'admin_schedule',
            'admin_schedule.interviewResult'
        ])
        ->orderBy('nama_lengkap', 'asc')
        ->get();


        $data = [];
        foreach ($applicants as $applicant) {
            $try = [];
            $try['id'] = $applicant->id;
            $try['nrp'] = $applicant->nrp;
            $try['name'] = $applicant->nama_lengkap;

            $try['divisi1'] = $applicant->division1?->name;
            $try['divisi2'] = $applicant->division2?->name;

            $schedule = $applicant->admin_schedule->first();

            $result1 = $schedule?->interviewResult?->firstWhere('division_id', $applicant->division_choice1);
            $result2 = $schedule?->interviewResult?->firstWhere('division_id', $applicant->division_choice2);


            $try['result1'] = $result1?->link_hasil;
            $try['status1'] = $result1?->statusTerima;
            $try['result2'] = $result2?->link_hasil;
            $try['status2'] = $result2?->statusTerima;

            $data[] = $try;
        }

        // dd($data); // Untuk debugging
        $title = 'All Applicant';
        return view('admin.allApplicant', [
            'title' => $title,
            'datas' => json_encode($data)
        ]);
    }

    public function applicantDetailIndex($applicantId)
    {
        $applicant = Applicant::with('division1', 'division2', 'applicantFile')->findOrFail($applicantId);
        
        $title = "Detail Applicant";

        return view('admin.detailApplicant', [
            'title' => $title,
            'data' => json_encode(new ApplicantDetailResource($applicant)) 
        ]);
    }

    public function login()
    {
        if (session('role') == 'admin') {
            return redirect()->route('admin.home');
        }
        return view('admin.login');
    }
}
