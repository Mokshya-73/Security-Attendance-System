<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApproverDgm extends Model
{
    protected $fillable = ['name', 'employee_id', 'user_core_data_id'];

    public function core()
    {
        return $this->belongsTo(UserCoreData::class, 'user_core_data_id');
    }

    public function managers()
    {
        return $this->hasMany(SecurityManager::class, 'approver_dgm_id');
    }
}
