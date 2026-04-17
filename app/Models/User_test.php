<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ✅ This tells Laravel to use user_core_data instead of users
    protected $table = 'user_core_data';

    protected $fillable = [
        'email',
        'employee_id',
        'password',
        'role_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function accessLevel()
    {
        return $this->belongsTo(UserAccessLevel::class, 'role_id');
    }

    public function getAuthIdentifierName()
    {
        return 'email'; // This remains default for Laravel
    }
}
