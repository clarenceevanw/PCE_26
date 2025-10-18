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

        $schedules = AdminSchedule::with([
            'schedule', 
            'applicant', 
            'interviewResult'
        ])
        ->join('schedules', 'admin_schedules.schedule_id', '=', 'schedules.id')
        ->where('admin_id', $admin->id)
        ->whereNotNull('applicant_id')
        ->orderBy('schedules.tanggal')
        ->orderBy('schedules.jam_mulai')
        ->select('admin_schedules.*', 'schedules.tanggal', 'schedules.jam_mulai')
        ->get();

        $data = $schedules->map(function ($schedule) {
            Carbon::setLocale('id');

            $result1 = $schedule->interviewResult->firstWhere('division_id', $schedule->applicant->division_choice1);
            $result2 = $schedule->interviewResult->firstWhere('division_id', $schedule->applicant->division_choice2);

            return [
                'applicant_id'    => $schedule->applicant_id,
                'date'            => Carbon::parse($schedule->schedule->tanggal)->translatedFormat('l, d F Y'),
                'time'            => Carbon::parse($schedule->schedule->jam_mulai)->format('H:i'),
                'nrp'             => $schedule->applicant->nrp,
                'isOnline'        => $schedule->isOnline,
                'name'            => $schedule->applicant->nama_lengkap,
                'id_line'         => $schedule->applicant->line_id,
                'no_hp'           => $schedule->applicant->no_hp,
                'status_interview' => $schedule->statusInterview,
                'link_hasil_result1' => $result1?->link_hasil,
                'link_hasil_result2' => $result2?->link_hasil,
            ];
        });

        $title = 'My Interview';

        return view('admin.myInterview', [
            'title' => $title,
            'datas' => $data->toJson()
        ]);
    }

    public function allInterviewIndex()
    {
        $schedules = AdminSchedule::with([
            'admin.division',
            'schedule',
            'applicant.division1',
            'applicant.division2',
            'interviewResult'
        ])
        ->join('schedules', 'admin_schedules.schedule_id', '=', 'schedules.id')
        ->whereNotNull('applicant_id')
        ->orderBy('schedules.tanggal')
        ->orderBy('schedules.jam_mulai')
        ->select('admin_schedules.*', 'schedules.tanggal', 'schedules.jam_mulai')
        ->get();

        $data = $schedules->map(function ($schedule) {
            Carbon::setLocale('id');

            $result1 = $schedule->interviewResult->firstWhere('division_id', $schedule->applicant->division_choice1);
            $result2 = $schedule->interviewResult->firstWhere('division_id', $schedule->applicant->division_choice2);

            return [
                'applicant_id'    => $schedule->applicant_id,
                'date'            => Carbon::parse($schedule->schedule->tanggal)->translatedFormat('l, d F Y'),
                'time'            => Carbon::parse($schedule->schedule->jam_mulai)->format('H:i'),
                'name'            => $schedule->applicant->nama_lengkap,
                'nrp'             => $schedule->applicant->nrp,
                'adminName'       => $schedule->admin->name,
                'divisi'          => $schedule->admin->division->name,
                'statusInterview' => $schedule->statusInterview ? 'Selesai' : 'Pending',
                'divisi1'         => $schedule->applicant->division1->name,
                'divisi2'         => $schedule->applicant->division2?->name, // Nullsafe operator jika pilihan 2 tidak ada
                'link_hasil_result1' => $result1?->link_hasil, // Nullsafe operator
                'link_hasil_result2' => $result2?->link_hasil, // Nullsafe operator
            ];
        });

        $title = 'All Interview';

        return view('admin.allInterview', [
            'title' => $title,
            'datas' => $data->toJson() // Konversi koleksi ke JSON
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
