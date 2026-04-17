<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityOfficer extends Model
{
    protected $fillable = [
        'title_id',
        'name',
        'nic',
        'telephone',
        'address',
        'nic_photo_path',
        'company_id',
        'assigned_patrol_id',
        'location_id',
        'user_core_data_id',
        'service_number',
    ];


    public function core()
    {
        return $this->belongsTo(UserCoreData::class, 'user_core_data_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function patrol()
    {
        return $this->belongsTo(PatrolOfficer::class, 'assigned_patrol_id');
    }

    public function title()
    {
        return $this->belongsTo(SecurityOfficerTitle::class, 'title_id');
    }
    public function titleRelation()
    {
        return $this->belongsTo(SecurityOfficerTitle::class, 'title_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
