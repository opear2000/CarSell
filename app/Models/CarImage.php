<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarImage extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['image_path','position'];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getUrl(): string
    {
        if (! $this->image_path) {
            return '/img/noimage.jpeg';
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        $path = $this->image_path;

        // Normalize storage path when it includes public/
        if (str_starts_with($path, 'public/')) {
            $path = substr($path, 7);
        }

        // Absolute public path
        if (str_starts_with($path, '/')) {
            if (file_exists(public_path(ltrim($path, '/')))) {
                return $path;
            }
        }

        // Storage disk path (public disk) e.g. images/xxx
        if (file_exists(storage_path('app/public/' . ltrim($path, '/')))) {
            return '/storage/' . ltrim($path, '/');
        }

        // Support legacy path from local disk (stored in app/private/public/images)
        if (str_starts_with($this->image_path, 'public/') && file_exists(storage_path('app/private/' . ltrim($this->image_path, '/')))) {
            $relative = substr($this->image_path, strlen('public/'));
            $publicStoragePath = storage_path('app/public/' . $relative);

            if (! file_exists($publicStoragePath)) {
                @mkdir(dirname($publicStoragePath), 0755, true);
                copy(storage_path('app/private/' . $this->image_path), $publicStoragePath);
            }

            return '/storage/' . ltrim($relative, '/');
        }

        // Fallback if file is directly under public web root (e.g. /images/xxx)
        if (file_exists(public_path(ltrim($path, '/')))) {
            return '/' . ltrim($path, '/');
        }

        return '/img/noimage.jpeg';
    }
}
