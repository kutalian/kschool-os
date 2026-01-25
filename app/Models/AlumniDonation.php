<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniDonation extends Model
{
    use HasFactory;

    protected $table = 'alumni_donations';

    protected $fillable = [
        'alumni_id',
        'amount',
        'donation_date',
        'purpose',
        'payment_method',
        'transaction_id',
        'receipt_file',
        'remarks',
    ];

    protected $casts = [
        'donation_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }
}
