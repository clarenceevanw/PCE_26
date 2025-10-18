<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $applicantFile = $this->applicantFile;
        return [
            'nama_lengkap' => $this->nama_lengkap,
            'nrp' => $this->nrp,
            'angkatan' => $this->angkatan,
            'prodi' => $this->prodi,
            'line_id' => $this->line_id,
            'no_hp' => $this->no_hp,
            'ipk' => $this->ipk,
            'jenis_kelamin' => $this->jenis_kelamin,
            'instagram' => $this->instagram,

            'divisi1' => $this->division1?->name,
            'divisi2' => $this->division2?->name ?? 'None',
            
            'motivasi' => $this->motivasi ?? 'None',
            'komitmen' => $this->komitmen ?? 'None',
            'kelebihan' => $this->kelebihan ?? 'None',
            'kekurangan' => $this->kekurangan ?? 'None',
            'pengalaman' => $this->pengalaman ?? 'None',
            
            'ktm'              => $applicantFile?->ktm ? asset(Storage::url($applicantFile->ktm)) : null,
            'transkrip'        => $applicantFile?->transkrip ? asset(Storage::url($applicantFile->transkrip)) : null,
            'bukti_kecurangan' => $applicantFile?->bukti_kecurangan ? asset(Storage::url($applicantFile->bukti_kecurangan)) : null,
            'skkk'             => $applicantFile?->skkk ? asset(Storage::url($applicantFile->skkk)) : null,
            'portofolio'       => $applicantFile?->portofolio,
        ];
    }
}