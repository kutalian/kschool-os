<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassTimetablePeriod extends Model
{
    protected $fillable = ['class_id', 'name', 'start_time', 'end_time'];
}
