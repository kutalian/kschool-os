<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    use HasFactory;

    protected $table = 'fee_types';

    public $timestamps = false; // Schema uses current_timestamp()

    protected $fillable = [
        'name',
        'amount',
        'description',
        'frequency',
        'is_active',
    ];
}
