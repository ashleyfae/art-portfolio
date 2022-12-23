<?php
/**
 * DeviationAdapter.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Services\PortfolioProviders\Adapters;

use App\Contracts\AdapterInterface;
use App\Services\PortfolioProviders\DataTransferObjects\Artwork;
use App\Services\PortfolioProviders\Enums\Provider;
use Illuminate\Support\Arr;

class DeviationAdapter implements AdapterInterface
{
    public function __construct(protected readonly array $deviation, protected readonly array $metadata)
    {

    }

    public function convertFromSource(): Artwork
    {
        $categories = $this->adaptCategories();

        return new Artwork(
            title: Arr::get($this->deviation, 'title'),
            description: Arr::get($this->metadata, 'description'),
            imageUrl: Arr::get($this->deviation, 'content.src'),
            publishedAt: Arr::get($this->deviation, 'published_time'),
            externalId: Arr::get($this->deviation, 'deviationid'),
            provider: Provider::DeviantArt,
            isFeatured: in_array('Featured', $categories, true),
            categories: $categories,
        );
    }

    protected function adaptCategories(): array
    {
        $categories = [];
        $galleries = Arr::get($this->metadata, 'galleries', []);

        if (! is_array($galleries)) {
            return $categories;
        }

        foreach($galleries as $gallery) {
            if ($name = Arr::get($gallery, 'name')) {
                $categories[] = $name;
            }
        }

        return $categories;
    }
}
