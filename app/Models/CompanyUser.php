<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyUser extends Model
{
    protected $fillable = ['name', 'email', 'company_id', 'user_core_data_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function core()
    {
        return $this->belongsTo(UserCoreData::class, 'user_core_data_id');
    }
}
