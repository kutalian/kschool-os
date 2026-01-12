<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;

    protected $table = 'student_fees';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'fee_type_id',
        'amount',
        'paid',
        'discount',
        'status',
        'due_date',
        'academic_year',
        'term',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'student_fee_id');
    }
}
