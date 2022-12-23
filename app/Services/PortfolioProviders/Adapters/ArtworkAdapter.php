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

class ArtworkAdapter implements AdapterInterface
{
    public function __construct(protected readonly \App\Services\PortfolioProviders\DataTransferObjects\Artwork $artworkDto)
    {

    }

    public function convertFromSource(): Artwork
    {
        $artwork = new Artwork();
        $artwork->title = $this->artworkDto->title;
        $artwork->description = $this->artworkDto->description;
        $artwork->published_at = $this->artworkDto->publishedAt;
        $artwork->is_featured = $this->artworkDto->isFeatured;

        return $artwork;
    }
}
