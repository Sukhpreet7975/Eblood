<?php

namespace App\Models;

use App\Models\User;
use MongoDB\Laravel\Eloquent\Model;

class BloodRequest extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'blood_requests';

    public $timestamps = true;

    protected $fillable = [
        'patient_name',
        'blood_group',
        'hospital',
        'city',
        'phone',
        'message',
        'status',
        'user_id',
        'admin_message',
        'status_updated_at',
    ];

    protected $casts = [
        'status_updated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}