<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'school_vehicles';

    protected $fillable = [
        'vehicle_number',
        'capacity',
        'driver_name',
        'driver_license',
        'driver_phone',
        'status',
    ];

    public function routes()
    {
        return $this->hasMany(TransportRoute::class);
    }
}
