<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityManager extends Model
{
    protected $fillable = ['name', 'employee_id', 'approver_dgm_id', 'user_core_data_id'];

    public function core()
    {
        return $this->belongsTo(UserCoreData::class, 'user_core_data_id');
    }

    public function approverDgm()
    {
        return $this->belongsTo(ApproverDgm::class, 'approver_dgm_id');
    }

    public function patrols()
    {
        return $this->hasMany(PatrolOfficer::class, 'assigned_manager_id');
    }
}
