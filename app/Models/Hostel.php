<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hostel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'address',
        'warden_name',
        'warden_contact',
        'description',
        'is_active',
    ];

    public function rooms()
    {
        return $this->hasMany(HostelRoom::class);
    }
}
