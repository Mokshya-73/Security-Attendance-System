<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccessLevel extends Model
{
    protected $fillable = ['role'];

    public function coreUsers()
    {
        return $this->hasMany(UserCoreData::class, 'role_id');
    }
}
