<?php

namespace App\Http\Controllers;

use App\Models\AdminSchedule;
use App\Models\Schedule;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class AdminScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nrp = Session::get('nrp');
        $admin = Admin::where('nrp', $nrp)->first();
        $isFilled = AdminSchedule::where('admin_id', $admin->id)->first();
        if(!$isFilled){
            $selectedSlots = json_decode($request->input('selectedSlots'), true);
            $adminId = $admin->id;
            foreach ($selectedSlots as $slot) {
                $date = $slot['date'];
                $hour = $slot['hour'];
                $isOnline = $slot['isOnline'];
                Log::info("Processing slot: Date - $date, Hour - $hour, isOnline - $isOnline");

                $existingSchedule = Schedule::where('tanggal', $date)
                ->where('jam_mulai', sprintf('%02d:30', $hour))
                ->first();

                if (!$existingSchedule) {
                    Schedule::create([
                        'tanggal' => $date,
                        'jam_mulai' => sprintf('%02d:30', $hour),
                    ]);
                    $existingSchedule = Schedule::where('tanggal', $date)
                    ->where('jam_mulai', sprintf('%02d:30', $hour))
                    ->first();
                }

                AdminSchedule::create([
                    'admin_id' => $adminId,
                    'schedule_id' => $existingSchedule->id,
                    'isOnline' => $isOnline,
                ]);
            };
            return response()->json(['success' => true, 'message' => 'Jadwal berhasil dicatat'], 201);
        }else{
            return response()->json(['success' => false, 'message' => "Admin sudah melakukan input"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AdminSchedule $adminSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdminSchedule $adminSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdminSchedule $adminSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminSchedule $adminSchedule)
    {
        //
    }
}
