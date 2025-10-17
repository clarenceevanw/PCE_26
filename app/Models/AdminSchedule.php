<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminSchedule extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'admin_id',
        'schedule_id',
        'isOnline',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    public function interviewResult()
    {
        return $this->hasMany(InterviewResult::class);
    }
}
