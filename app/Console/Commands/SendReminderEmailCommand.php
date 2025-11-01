<?php

namespace App\Console\Commands;

use App\Mail\ReminderIsiJadwal;
use App\Models\Applicant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendReminderEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:reminder-jadwal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kirim email ke semua applicant yang belum isi jadwal';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Mencari applicant yang belum isi jadwal...");

        $applicants = Applicant::where('phase', '<=', 1)->get();

        if ($applicants->isEmpty()) {
            $this->info("Semua applicant sudah mengisi jadwal!");
            return;
        }

        Log::info("Applicants: " . json_encode($applicants));
        $this->info("Menambahkan email ke antrian...");
        foreach ($applicants as $applicant) {
            $email = $applicant->nrp . '@john.petra.ac.id';
            Mail::to($email)->queue(new ReminderIsiJadwal($applicant));
            $this->line("Dimasukkan ke queue: {$applicant->nama_lengkap} ({$email})");
        }

        $this->info("Semua email sudah dimasukkan ke queue! Worker akan memprosesnya segera.");
    }
}
