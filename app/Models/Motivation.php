<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Motivation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'applicant_id',
        'motivasi',
        'komitmen',
        'kelebihan',
        'kekurangan',
        'pengalaman',
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
