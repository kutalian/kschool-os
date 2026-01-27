<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Process and save an image.
     *
     * @param UploadedFile $file
     * @param string $directory Directory within 'public' disk
     * @param array $options [width, height, quality, format]
     * @param string|null $filename Custom filename
     * @return string Path to the processed image relative to public storage
     */
    public function process(UploadedFile $file, string $directory, array $options = [], ?string $filename = null): string
    {
        $width = $options['width'] ?? null;
        $height = $options['height'] ?? null;
        $quality = $options['quality'] ?? 80;
        $format = $options['format'] ?? 'webp'; // Default to webp for better compression

        if (!$filename) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '_' . time() . '.' . $format;
        } else {
            // Ensure correct extension if format is forced
            $filename = pathinfo($filename, PATHINFO_FILENAME) . '.' . $format;
        }

        $image = $this->manager->read($file);

        // Optimization: Resize if dimensions provided
        if ($width && $height) {
            $image->cover($width, $height);
        } elseif ($width || $height) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Encode to desired format and quality
        $encoded = $image->encodeByMediaType("image/{$format}", quality: $quality);

        $path = "{$directory}/{$filename}";
        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Delete an image from public storage.
     */
    public function delete(string $path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
