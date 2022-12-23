<?php
/**
 * ArtworkAdapter.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Services\PortfolioProviders\Adapters;

use App\Contracts\AdapterInterface;
use App\Models\Artwork;
use App\Models\Image;

class ArtworkAdapter implements AdapterInterface
{
    public function __construct(protected readonly \App\Services\PortfolioProviders\DataTransferObjects\Artwork $artworkDto)
    {

    }

    public function convertFromSource(): Artwork
    {
        $image = new Image();
        $image->title = $this->artworkDto->title;
        $image->description = $this->artworkDto->description;

        $artwork = new Artwork();
        $artwork->published_at = $this->artworkDto->publishedAt;
        $artwork->is_featured = $this->artworkDto->isFeatured;

        if ($this->artworkDto->externalId) {
            $artwork->external_ids = [
                $this->artworkDto->provider->value => $this->artworkDto->externalId,
            ];
        }

        $artwork->images[0] = $image;

        return $artwork;
    }
}
