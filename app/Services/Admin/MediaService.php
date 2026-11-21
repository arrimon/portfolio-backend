<?php

namespace App\Services\Admin;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;

class MediaService
{
    // SVG is intentionally NOT allowed.
    private const KINDS = [
        'image' => [
            'mimes' => ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'],
            'max' => 2 * 1024 * 1024,
        ],
        'document' => [
            'mimes' => ['application/pdf' => 'pdf'],
            'max' => 5 * 1024 * 1024,
        ],
    ];

    public function upload(UploadedFile $file, string $kind = 'image'): Media
    {
        $rule = self::KINDS[$kind] ?? throw new InvalidArgumentException("Unknown media kind: {$kind}");

        $mime = $file->getMimeType(); // sniffed from file content, not from the client

        if (! isset($rule['mimes'][$mime]) || $file->getSize() > $rule['max']) {
            throw ValidationException::withMessages([
                'file' => 'Unsupported file type or file is too large.',
            ]);
        }

        $path = $file->storeAs(
            'uploads/'.now()->format('Y/m'),
            Str::uuid().'.'.$rule['mimes'][$mime],
            'public'
        );

        return Media::create([
            'disk' => 'public',
            'path' => $path,
            'original_name' => Str::limit($file->getClientOriginalName(), 200, ''),
            'mime_type' => $mime,
            'size' => $file->getSize(),
            'uploaded_by' => auth()->id(),
        ]);
    }

    public function delete(Media $media): void
    {
        if ($media->isInUse()) {
            throw ValidationException::withMessages([
                'media' => 'This file is in use and cannot be deleted.',
            ]);
        }

        $media->delete(); // soft delete; physical file kept
    }
}
