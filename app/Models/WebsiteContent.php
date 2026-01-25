<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteContent extends Model
{
    use HasFactory;

    protected $table = 'website_content';

    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'content',
        'image_path',
        'action_text',
        'action_url',
        'display_order',
        'is_active',
        'meta_description',
        'settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
    ];
}
