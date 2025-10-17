<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicantDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
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

            'divisi1' => $this->division1->name,
            'divisi2' => $this->division2->name ?? 'None',
            
            'motivasi' => $this->motivasi ?? 'None',
            'komitmen' => $this->komitmen ?? 'None',
            'kelebihan' => $this->kelebihan ?? 'None',
            'kekurangan' => $this->kekurangan ?? 'None',
            'pengalaman' => $this->pengalaman ?? 'None',
            
            'ktm' => $this->whenNotNull($this->applicantFile->ktm, Storage::url($this->applicantFile->ktm)),
            'transkrip' => $this->whenNotNull($this->applicantFile->transkrip, Storage::url($this->applicantFile->transkrip)),
            'bukti_kecurangan' => $this->whenNotNull($this->applicantFile->bukti_kecurangan, Storage::url($this->applicantFile->bukti_kecurangan)),
            'skkk' => $this->whenNotNull($this->applicantFile->skkk, Storage::url($this->applicantFile->skkk)),
            'portofolio' => $this->applicantFile->portofolio ?? null,
        ];
    }
}