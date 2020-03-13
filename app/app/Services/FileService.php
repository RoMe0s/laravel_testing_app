<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function saveFile(UploadedFile $file): string
    {
        $file->move(public_path('pictures'), $file->getClientOriginalName());
        return 'pictures/' . $file->getClientOriginalName();
    }

    public function deleteFile(string $filePath): void
    {
        $fullFilePath = public_path($filePath);

        if (Storage::exists($fullFilePath)) {
            Storage::delete($fullFilePath);
        }
    }
}
