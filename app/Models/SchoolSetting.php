<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'tagline',
        'school_address',
        'school_phone',
        'school_email',
        'school_website',
        'currency_symbol',
        'currency_code',
        'theme_color',
        'logo_path',
        'favicon_path',
        'principal_name',
        'principal_signature',
        'academic_year',
        'current_term',
        'timezone',
        'date_format',
        'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];
}
