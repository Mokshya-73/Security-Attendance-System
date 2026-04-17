<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityOfficerTitle extends Model
{
    protected $fillable = ['title'];

    public function officers()
    {
        return $this->hasMany(SecurityOfficer::class, 'title_id');
    }
}
