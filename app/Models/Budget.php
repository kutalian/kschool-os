<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budgets';

    protected $fillable = [
        'category',
        'academic_year',
        'allocated_amount',
        'spent_amount',
        'description',
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
        'spent_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    // Note: remaining_amount is a stored generated column in the database schema, 
    // so we don't need to manually calculate it, but we can't write to it.

    public function getPercentageUsedAttribute()
    {
        if ($this->allocated_amount > 0) {
            return round(($this->spent_amount / $this->allocated_amount) * 100, 1);
        }
        return 0;
    }
}
