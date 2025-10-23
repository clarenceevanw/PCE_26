<?php

namespace App\Exports;

use App\Models\Applicant;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ApplicantsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        // Query ini sudah benar, tidak perlu diubah.
        // Eager loading akan tetap berfungsi.
        return Applicant::with([
            'division1',
            'division2',
            'admin_schedule',
            'admin_schedule.interviewResult'
        ])->orderBy('nama_lengkap', 'asc');
    }

    /**
     * @var Applicant $applicant
     */
    public function map($applicant): array
    {
        // ----- PERBAIKAN DI SINI -----
        // Kita tambahkan ->first() setelah admin_schedule
        // untuk mengambil model pertama dari collection
        $schedule = $applicant->admin_schedule?->first();
        $url = env('APP_URL') . '/storage/';
        return [
            $applicant->nrp,
            $applicant->nama_lengkap,
            $applicant->jenis_kelamin,
            $applicant->angkatan,
            $applicant->prodi,
            $applicant->ipk,
            $applicant->line_id,
            $applicant->no_hp,
            $applicant->instagram,
            $applicant->division1?->name,
            // Menggunakan variabel $schedule yang sudah diambil
            $schedule?->interviewResult?->firstWhere('division_id', $applicant->division_choice1)?->link_hasil,
            $applicant->division2?->name,
            // Menggunakan variabel $schedule yang sudah diambil
            $schedule?->interviewResult?->firstWhere('division_id', $applicant->division_choice2)?->link_hasil,
            $applicant->motivasi,
            $applicant->kelebihan,
            $applicant->kekurangan,
            $applicant->komitmen,
            $applicant->pengalaman,
            $applicant->applicantFile?->ktm ? $url . $applicant->applicantFile?->ktm : "",
            $applicant->applicantFile?->transkrip ? $url . $applicant->applicantFile?->transkrip : "",
            $applicant->applicantFile?->bukti_kecurangan ? $url . $applicant->applicantFile?->bukti_kecurangan : "",
            $applicant->applicantFile?->skkk ? $url . $applicant->applicantFile?->skkk : "",
            $applicant->applicantFile?->portofolio
        ];
    }

    public function headings(): array
    {
        // Headings sudah benar, tidak perlu diubah
        return [
            'NRP',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Angkatan',
            'Program Studi',
            'IPK',
            'Line ID',
            'No HP',
            'Instagram',
            'Divisi 1',
            'Hasil Interview 1',
            'Divisi 2',
            'Hasil Interview 2',
            'Motivasi',
            'Kelebihan',
            'Kekurangan',
            'Komitmen',
            'Pengalaman',
            'KTM',
            'Transkrip',
            'Bukti Kecurangan',
            'SKKK',
            'Portofolio'
        ];
    }
}

