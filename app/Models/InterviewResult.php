<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class InterviewResult extends Model
{
    use HasUuids;
    protected $fillable = [
        'admin_schedule_id',
        'division_id',
        'link_hasil',
        'statusTerima',
    ];

    public function adminSchedule()
    {
        return $this->belongsTo(AdminSchedule::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
