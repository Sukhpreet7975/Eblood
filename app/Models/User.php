<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
        'is_donor',
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
            'is_donor' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return ($this->role ?? null) === 'admin';
    }

    public function isDonor(): bool
    {
        if (($this->role ?? null) === 'admin') {
            return false;
        }

        return (bool) ($this->is_donor ?? false) || (($this->role ?? null) === 'donor');
    }

    public function isRequester(): bool
    {
        return ($this->role ?? null) === 'requester';
    }

    public function isUser(): bool
    {
        return ! $this->isAdmin();
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeDonors($query)
    {
        return $query->where(function ($query) {
            $query->where('is_donor', true)
                ->orWhere('role', 'donor');
        });
    }

    public function scopeUsers($query)
    {
        return $query->where('role', '!=', 'admin');
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