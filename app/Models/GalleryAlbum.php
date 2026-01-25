<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryAlbum extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'album_date',
        'event_id',
        'is_public',
        'created_by',
    ];

    protected $casts = [
        'album_date' => 'date',
        'is_public' => 'boolean',
    ];

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class, 'album_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
