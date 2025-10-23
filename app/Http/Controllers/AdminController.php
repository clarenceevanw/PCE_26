<?php

namespace App\Http\Controllers;

use App\Exports\ApplicantsExport;
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
use Maatwebsite\Excel\Facades\Excel;

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

            $result1 = $schedule->interviewResult?->firstWhere('division_id', $schedule->applicant->division_choice1);
            $result2 = $schedule->interviewResult?->firstWhere('division_id', $schedule->applicant->division_choice2);

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
            'divisions' => Division::whereNotIn('slug', ['bph', 'sc', 'bphk', 'dosen'])->get(),
            'datas' => $data->toJson(),
        ]);
    }

    public function accApplicantIndex()
    {
        $schedules = AdminSchedule::with(['applicant.division1', 'applicant.division2', 'interviewResult'])
                    ->where('statusInterview', 1)
                    ->get();
        
        $data = $schedules->map(function ($schedule) {
            if (!$schedule->applicant) {
                return null;
            }
            $result1 = $schedule->interviewResult->firstWhere('division_id', $schedule->applicant->division_choice1);
            $result2 = $schedule->interviewResult->firstWhere('division_id', $schedule->applicant->division_choice2);
            
            return [
                'id'              => $schedule->applicant->id,
                'nrp'             => $schedule->applicant->nrp,
                'name'            => $schedule->applicant->nama_lengkap,
                'divisi1'         => $schedule->applicant->division1->name,
                'divisi2'         => $schedule->applicant->division2->name,
                'result1'         => $result1?->link_hasil, // Nullsafe operator
                'result2'         => $result2?->link_hasil, // Nullsafe operator
                'status1'         => $result1?->statusTerima,
                'status2'         => $result2?->statusTerima,
            ];
        })->filter();
        
        $title = 'Accept or Reject Applicant';
        return view('admin.tolakTerima', [
            'title' => $title,
            'divisions' => Division::whereNotIn('slug', ['bph', 'sc', 'bphk', 'dosen'])->get(),
            'datas' => $data
        ]);
    }

    public function accApplicantAction(Request $request)
    {
        $validated = $request->validate([
            'applicant_id'  => 'required|exists:applicants,id',
            'division_name' => 'required|string|exists:divisions,name',
            'isAccepted'        => 'required|integer|in:0,1',
        ]);

        $division = Division::where('name', $validated['division_name'])->first();

        if ($division->id != Session::get('division_id') && Session::get('division_slug') != 'bph') {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki hak akses untuk divisi ini.']); // 403 Forbidden
        }

        $result = InterviewResult::where('division_id', $division->id)
            ->whereHas('adminSchedule', function ($query) use ($validated) {
                $query->where('applicant_id', $validated['applicant_id'])
                    ->where('statusInterview', 1);
            })
            ->first();

        if (!$result) {
            return response()->json(['success' => false, 'message' => 'Hasil interview untuk pelamar ini tidak ditemukan atau interview belum selesai.'], 404); // 404 Not Found
        }

        $result->update([
            'statusTerima' => $validated['isAccepted']
        ]);

        $message = $validated['isAccepted'] ? 'Pelamar berhasil diterima.' : 'Pelamar berhasil ditolak.';
        return response()->json(['success' => true, 'message' => $message], 200);
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
            'datas' => json_encode($data),
            'divisions' => Division::whereNotIn('slug', ['bph', 'sc', 'bphk', 'dosen'])->get()
        ]);
    }

    public function applicantDetailIndex($applicantId)
    {
        $applicant = Applicant::with('division1', 'division2', 'applicantFile')->findOrFail($applicantId);
        
        $title = "Detail Applicant";

        return view('admin.detailApplicant', [
            'title' => $title,
            'data' => (new ApplicantDetailResource($applicant))->toArray(request()),
        ]);
    }

    public function exportApplicants()
    {
        return Excel::download(new ApplicantsExport(), 'applicants.xlsx');
    }

    public function login()
    {
        if (session('role') == 'admin') {
            return redirect()->route('admin.home');
        }
        return view('admin.login');
    }
}
