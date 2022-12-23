<?php
/**
 * SetImageDimensions.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Actions\Images;

use App\DataTransferObjects\ImageDimensions;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class SetImageDimensions
{
    public function parseAndSet(Image $image): Image
    {
        $filePath = Storage::disk('public')->path($image->image_path);
        if (! $filePath) {
            return $image;
        }

        $imageDimensions = ImageDimensions::fromArray(
            $this->getImageDimensions($filePath)
        );

        $image->width = $imageDimensions->width;
        $image->height = $imageDimensions->height;
        $image->mime = $imageDimensions->mime;
        $image->bytes = $this->getImageFileSize($filePath);

        return $image;
    }

    protected function getImageDimensions(string $filePath): array
    {
        return (array) getimagesize($filePath);
    }

    protected function getImageFileSize(string $filePath): ?int
    {
        return filesize($filePath) ?: null;
    }

}
