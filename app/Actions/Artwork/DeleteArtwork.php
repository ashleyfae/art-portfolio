<?php
/**
 * DeleteArtwork.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Actions\Artwork;

use App\Models\Artwork;
use App\Models\Image;

class DeleteArtwork
{
    public function execute(Artwork $artwork): void
    {
        foreach($artwork->images as $image) {
            if ($this->shouldDeleteImage($image)) {
                $image->delete();
            }
        }

        $artwork->delete();
    }

    protected function shouldDeleteImage(Image $image): bool
    {
        return $image->artworks()->count() === 1;
    }
}
