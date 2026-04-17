<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserCoreData extends Authenticatable
{
    protected $table = 'user_core_data';

    protected $fillable = [
        'email',
        'employee_id',
        'password',
        'role_id',
        'status'
    ];

    protected $hidden = ['password'];

    public function accessLevel()
    {
        return $this->belongsTo(UserAccessLevel::class, 'role_id');
    }

    public function companyUser()
    {
        return $this->hasOne(CompanyUser::class);
    }

    public function approverDgm()
    {
        return $this->hasOne(ApproverDgm::class);
    }

    public function securityManager()
    {
        return $this->hasOne(SecurityManager::class);
    }

    public function patrolOfficer()
    {
        return $this->hasOne(PatrolOfficer::class);
    }

    public function securityOfficer()
    {
        return $this->hasOne(SecurityOfficer::class);
    }
}
