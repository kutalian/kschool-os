<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransportRoute extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'school_transport_routes';

    protected $fillable = [
        'route_name',
        'start_point',
        'end_point',
        'fare',
        'vehicle_id',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class); // Inverse relation
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
