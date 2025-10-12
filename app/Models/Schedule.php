<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'tanggal',
        'jam_mulai'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function adminSchedule()
    {
        return $this->hasMany(AdminSchedule::class, 'schedule_id', 'id');
    }
}
