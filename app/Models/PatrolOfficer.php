<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatrolOfficer extends Model
{
    protected $fillable = ['name', 'slt_employee_id', 'assigned_manager_id', 'location_id', 'user_core_data_id'];

    public function core()
    {
        return $this->belongsTo(UserCoreData::class, 'user_core_data_id');
    }

    public function manager()
    {
        return $this->belongsTo(SecurityManager::class, 'assigned_manager_id');
    }

    public function officers()
    {
        return $this->hasMany(SecurityOfficer::class, 'assigned_patrol_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
