<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    use HasFactory;

    protected $table = 'biodatas'; // Nama tabel di database

    protected $fillable = [
        'nama_lengkap',
        'nrp',
        'angkatan',
        'prodi',
        'id_line',
        'no_hp',
        'divisi1',
        'divisi2',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}