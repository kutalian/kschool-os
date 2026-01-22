<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'item_id',
        'movement_type',
        'quantity',
        'from_location',
        'to_location',
        'issued_to',
        'reason',
        'movement_date',
        'handled_by',
    ];

    protected $casts = [
        'movement_date' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'issued_to');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}
