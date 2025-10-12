<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory, HasUuids;

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function adminSchedule()
    {
        return $this->hasMany(AdminSchedule::class, 'admin_id', 'id');
    }
}
