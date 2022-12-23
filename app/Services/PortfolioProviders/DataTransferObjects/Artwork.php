<?php
/**
 * Artwork.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Services\PortfolioProviders\DataTransferObjects;

use App\Services\PortfolioProviders\Enums\Provider;

class Artwork
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $description,
        public readonly ?string $imageUrl,
        public readonly ?int $publishedAt,
        public readonly ?string $externalId,
        public readonly Provider $provider,
        public readonly bool $isFeatured,
        public readonly array $categories
    ) {

    }
}
