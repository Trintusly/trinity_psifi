<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileSystemHelper
{
    public static function uploadFile(UploadedFile $file, string $directory = 'uploads', ?string $fileName = null, int $width = 256, int $height = 256)
    {
        try {
            // Generate a unique file name if not provided
            $fileName = $fileName ?? time() . '_' . $file->getClientOriginalName();

            // Ensure the directory exists
            $path = public_path($directory);
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            // Get the file content
            $fileContent = file_get_contents($file->getRealPath());

            // Create image resource from file
            $image = imagecreatefromstring($fileContent);

            if ($image === false) {
                throw new \Exception('Unsupported image format or corrupted image.');
            }

            // Resize the image to the provided width and height
            $resizedImage = imagescale($image, $width, $height);

            if ($resizedImage === false) {
                throw new \Exception('Failed to resize the image.');
            }

            // Save the resized image as JPEG
            $destinationPath = $path . '/' . $fileName . '.jpg';  // Force saving as .jpg
            imagejpeg($resizedImage, $destinationPath, 90); // 90 is the quality (0-100)

            // Free up memory
            imagedestroy($image);
            imagedestroy($resizedImage);

            return $directory . '/' . $fileName . '.jpg';
        } catch (\Exception $e) {
            return false;
        }
    }
}
