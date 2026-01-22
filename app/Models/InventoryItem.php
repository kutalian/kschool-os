<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'item_name',
        'category',
        'item_code',
        'description',
        'quantity',
        'unit',
        'location',
        'purchase_date',
        'purchase_price',
        'supplier',
        'warranty_expiry',
        'condition_status',
        'is_active',
    ];

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class, 'item_id');
    }
}
