<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CmsTheme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'directory',
        'screenshot',
        'version',
        'is_active',
        'config',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'config' => 'array',
    ];

    // Helper to activate this theme and deactivate others
    public function activate()
    {
        self::where('is_active', true)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
        Cache::forget('active_theme');
    }

    /**
     * Get the theme's manifest from theme.json
     */
    public function getManifestAttribute()
    {
        return Cache::remember("theme_manifest_{$this->directory}", 86400, function () {
            $path = resource_path("views/themes/{$this->directory}/theme.json");
            if (file_exists($path)) {
                return json_decode(file_get_contents($path), true);
            }
            return [];
        });
    }
}
