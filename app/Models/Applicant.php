<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'nama_lengkap',
        'nrp',
        'angkatan',
        'prodi',
        'ipk',
        'jenis_kelamin',
        'line_id',
        'no_hp',
        'instagram',
        'division_choice1',
        'division_choice2',
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

    public function division1()
    {
        return $this->belongsTo(Division::class, 'division_choice1', 'id');
    }

    public function division2()
    {
        return $this->belongsTo(Division::class, 'division_choice2', 'id');
    }

    public function applicantFile()
    {
        return $this->hasOne(ApplicantFile::class);
    }

    public function admin_schedule()
    {
        return $this->hasMany(AdminSchedule::class);
    }
}
