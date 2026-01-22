<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    public $timestamps = false; // Only created_at exists in schema, but typical use might want typical timestamps. Schema says created_at.

    protected $fillable = [
        'name',
        'description',
        'icon',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'category_id');
    }
}
