<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use Illuminate\Database\Eloquent\Model;

class ApplicantFile extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'applicant_id',
        'ktm',
        'transkrip',
        'bukti_kecurangan',
        'skkk',
        'portofolio',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id'. 'id');
    }
}
