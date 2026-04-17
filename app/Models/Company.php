<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'brn',
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'website',
        'license_number',
        'license_expiry',
    ];

    protected $casts = [
        'license_expiry' => 'date', // ✅ Ensures date is cast properly
    ];

    public function users()
    {
        return $this->hasMany(CompanyUser::class);
    }

    public function securityOfficers()
    {
        return $this->hasMany(SecurityOfficer::class);
    }
}
