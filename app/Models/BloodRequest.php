<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class BloodRequest extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'blood_requests';

    protected $fillable = [
        'patient_name',
        'blood_group',
        'hospital',
        'city',
        'phone',
        'message',
    ];
}