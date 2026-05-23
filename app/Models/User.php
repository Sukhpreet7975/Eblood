<?php

namespace App\Models;

use MongoDB\Laravel\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $connection = 'mongodb';

    protected $collection = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'blood_group',
        'city',
        'address',
        'available',
        'profile_image',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return ($this->role ?? null) === 'admin';
    }

    public function isDonor(): bool
    {
        return ($this->role ?? null) === 'donor';
    }

    public function isRequester(): bool
    {
        return ($this->role ?? null) === 'requester';
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeDonors($query)
    {
        return $query->where('role', 'donor');
    }

    public function scopeRequesters($query)
    {
        return $query->where('role', 'requester');
    }

    public function requests()
    {
        return $this->hasMany(BloodRequest::class, 'user_id');
    }
}