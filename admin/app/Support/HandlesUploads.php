<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HandlesUploads
{
    protected function storeUpload(Request $request, string $field, ?string $existing = null): ?string
    {
        if (! $request->hasFile($field)) {
            return $existing;
        }

        if ($existing) {
            Storage::disk('public')->delete($existing);
        }

        /** @var UploadedFile $file */
        $file = $request->file($field);

        return $file->store('uploads', 'public');
    }

    protected function deleteUpload(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
