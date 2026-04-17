<?php

namespace App\Models\PatrolOfficer;

use Illuminate\Database\Eloquent\Model;
use App\Models\PatrolOfficer;
use App\Models\SecurityOfficer;
use App\Models\admin\ShiftType;

class Timecard extends Model
{
    protected $fillable = [
        'patrol_officer_id',
        'security_officer_id',
        'shift_type_id',
        'started_at',
        'ended_at',
        'is_pay',
        'is_overtime',
        'overtime_hours',
        'remarks',
        'worked_hours',
    ];

    public function officer()
    {
        return $this->belongsTo(\App\Models\PatrolOfficer::class, 'patrol_officer_id');
    }

    public function securityOfficer()
    {
        return $this->belongsTo(SecurityOfficer::class, 'security_officer_id');
    }

    public function shiftType()
    {
        return $this->belongsTo(ShiftType::class);
    }


}
