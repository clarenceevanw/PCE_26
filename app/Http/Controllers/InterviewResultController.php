<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\AdminSchedule;
use App\Models\Applicant;
use App\Models\InterviewResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InterviewResultController extends Controller
{
    public function storeHasil(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'link_hasil_result1' => 'required|url',
            'link_hasil_result2' => 'required|url',
        ], [
            'link_hasil_result1.required' => 'Link hasil 1 wajib diisi',
            'link_hasil_result1.url' => 'Link hasil 1 harus berupa URL yang valid',
            'link_hasil_result2.required' => 'Link hasil 2 wajib diisi',
            'link_hasil_result2.url' => 'Link hasil 2 harus berupa URL yang valid',
        ]);

        if ($valid->fails()) {
            $errors = $valid->errors()->toArray();
    
            // Flatten the error messages into a single string
            $errorMessages = [];
            foreach ($errors as $messages) {
                $errorMessages = array_merge($errorMessages, $messages);
            }
            $errorString = implode('<br>', $errorMessages);

            return response()->json(['success' => false, 'message' => $errorString]);
        }
        $nrp = Session::get('nrp');
        $nrpApplicant = $request->nrp;
        $admin = Admin::where('nrp', $nrp)->first();
        $applicant = Applicant::where('nrp', $nrpApplicant)->first();
        DB::beginTransaction();
        try {
            $adminSchedule = AdminSchedule::where('admin_id', $admin->id)
                ->where('applicant_id', $applicant->id)
                ->firstOrFail();

            $adminSchedule->statusInterview = 1;
            $adminSchedule->save();
            Log::info('Admin Schedule updated: ' . $adminSchedule);
            InterviewResult::create([
                'admin_schedule_id' => $adminSchedule->id,
                'division_id' => $applicant->division_choice1,
                'link_hasil' => $request->link_hasil_result1,
            ]);
            InterviewResult::create([
                'admin_schedule_id' => $adminSchedule->id,
                'division_id' => $applicant->division_choice2,
                'link_hasil' => $request->link_hasil_result2,
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Link berhasil di submit'], 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 201);
        }
    }
}
