<?php

namespace App\Http\Controllers;

use App\Models\AdminSchedule;
use App\Models\Schedule;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();

        try {
            $admin = Admin::where('nrp', Session::get('nrp'))->firstOrFail();
            //tanggal 22 Okt 2025
            $limitDate = Carbon::create(2025, 10, 22, 23, 59, 0, "Asia/Jakarta");
            $now = Carbon::now("Asia/Jakarta");
            
            $newSlotsInput = json_decode($request->input('selectedSlots'), true) ?? [];
            $newSlotsLookup = [];
            foreach ($newSlotsInput as $slot) {
                $key = $slot['date'] . '_' . sprintf('%02d:30:00', $slot['hour']);
                $newSlotsLookup[$key] = $slot;
            }

            $existingAdminSchedules = AdminSchedule::where('admin_id', $admin->id)->with('schedule')->get();
            $existingSlotsLookup = [];
            foreach ($existingAdminSchedules as $adminSchedule) {
                $key = $adminSchedule->schedule->tanggal . '_' . $adminSchedule->schedule->jam_mulai;
                $existingSlotsLookup[$key] = $adminSchedule;
            }

            foreach ($newSlotsLookup as $key => $newSlot) {
                //kalu ada jadwal baru yang nggak ada di jadwal lama, bikin jadwal baru
                if (!isset($existingSlotsLookup[$key])) {
                    $schedule = Schedule::firstOrCreate([
                        'tanggal' => $newSlot['date'],
                        'jam_mulai' => sprintf('%02d:30:00', $newSlot['hour'])
                    ]);

                    AdminSchedule::create([
                        'admin_id' => $admin->id,
                        'schedule_id' => $schedule->id,
                        'isOnline' => $newSlot['isOnline'],
                    ]);
                } else {
                    //kalau udh ada jadwalnya, tapi ada perubahan isOnline kita update isOnlinenya
                    $existingAdminSchedule = $existingSlotsLookup[$key];
                    if ($existingAdminSchedule->isOnline != $newSlot['isOnline']) {
                        //Jika udh di booking tidak bisa diubah lagi untuk perubahan online
                        if (!is_null($existingAdminSchedule->applicant_id)) {
                            DB::rollBack();
                            $scheduleTime = $existingAdminSchedule->schedule->tanggal . ' jam ' . $existingAdminSchedule->schedule->jam_mulai;
                            return response()->json([
                                'success' => false,
                                'message' => "Jadwal pada tanggal $scheduleTime yang sudah di booking tidak dapat diubah."
                            ], 409);
                        }
                        $existingAdminSchedule->isOnline = $newSlot['isOnline'];
                        $existingAdminSchedule->save();
                    }
                }
            }
            
            //Untuk mengecek kalau ada jadwal lama yang nggak ada di input baru, berarti admin ingin menghapusnya.
            foreach ($existingSlotsLookup as $key => $scheduleToDelete) {
                if (!isset($newSlotsLookup[$key])) {
                    $tanggal = $scheduleToDelete->schedule->tanggal;
                    //untuk mengatasi kondisi kalau jadwal dihapus setelah 23 Oktober 2025
                    if ($now->isAfter($limitDate)) {
                        DB::rollBack();
                        return response()->json([
                            'success' => false,
                            'message' => "Jadwal pada tanggal $tanggal tidak dapat dihapus karena setelah 22 Oktober 2025."
                        ], 409);
                    }
                    //Cek kalau udah di booking, dirollback dan kirim error agar jadwal tidak dihapus sembarangan. (jaga - jaga kalau ada yg main mainin component di frontend)
                    if (!is_null($scheduleToDelete->applicant_id)) { 
                        DB::rollBack();
                        $scheduleTime = $scheduleToDelete->schedule->tanggal . ' jam ' . $scheduleToDelete->schedule->jam_mulai;
                        return response()->json([
                            'success' => false, 
                            'message' => "Jadwal pada $scheduleTime tidak dapat dihapus karena sudah dibooking oleh applicant."
                        ], 409);
                    }
                    $scheduleToDelete->delete();
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Jadwal berhasil diperbarui!'], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan jadwal: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan sistem saat menyimpan jadwal.'], 500);
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
