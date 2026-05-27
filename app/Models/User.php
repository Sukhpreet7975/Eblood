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

        // Prefer the explicit `is_donor` flag, fall back to legacy `role === 'donor'` for compatibility.
        return (bool) ($this->is_donor ?? false) || (($this->role ?? null) === 'donor');
    }

    public function isRequester(): bool
    {
        // Requester concept has been unified into `user` — treat non-admin, non-donor users as requesters for compatibility.
        if ($this->isAdmin()) {
            return false;
        }

        if (($this->role ?? null) === 'requester') {
            return true; // legacy support
        }

        // New semantics: a regular `user` who is not donor-enabled is considered a requester-equivalent.
        return (($this->role ?? null) === 'user' || ($this->role ?? null) === null) && ! ($this->is_donor ?? false);
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
        // All non-admin accounts. Keeps compatibility with legacy role values.
        return $query->where(function ($q) {
            $q->where('role', '!=', 'admin')
                ->orWhereNull('role');
        });
    }

    public function scopeRequesters($query)
    {
        // Requesters are users who are not admins and not donor-enabled. Keep legacy 'requester' role as fallback.
        return $query->where(function ($q) {
            $q->where('role', 'requester')
                ->orWhere(function ($q2) {
                    $q2->where(function ($q3) {
                        $q3->where('role', 'user')->orWhereNull('role');
                    })->where(function ($q4) {
                        $q4->where('is_donor', '!=', true)->orWhereNull('is_donor');
                    });
                });
        });
    }

    public function requests()
    {
        return $this->hasMany(BloodRequest::class, 'user_id');
    }
}