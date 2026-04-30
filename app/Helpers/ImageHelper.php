<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Get the full URL for a car image
     * 
     * @param string|null $imagePath
     * @param string $default
     * @return string
     */
    public static function getImageUrl(?string $imagePath, string $default = '/img/noimage.jpeg'): string
    {
        if (!$imagePath) {
            return $default;
        }

        // If it's already a full URL (http/https), return as is
        if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
            return $imagePath;
        }

        // If it starts with /, it's already a root path - check if file exists
        if (str_starts_with($imagePath, '/')) {
            // Convert to full filesystem path to check existence
            $fullPath = public_path(ltrim($imagePath, '/'));
            if (file_exists($fullPath)) {
                return $imagePath;
            }
            return $default;
        }

        // Otherwise, it's a relative path in storage - check if file exists
        $fullPath = storage_path('app/public/' . $imagePath);
        if (file_exists($fullPath)) {
            return '/storage/' . $imagePath;
        }

        return $default;
    }
}
