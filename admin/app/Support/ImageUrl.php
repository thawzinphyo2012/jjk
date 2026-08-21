<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class ImageUrl
{
    /** Full URL for admin panel previews */
    public static function admin(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }

    /** URL/path for public website frontend */
    public static function frontend(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
