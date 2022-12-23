<?php

namespace Tests\Feature\Services\PortfolioProviders\Adapters;

use App\Services\PortfolioProviders\Adapters\ArtworkAdapter;
use App\Services\PortfolioProviders\DataTransferObjects\Artwork as ArtworkDto;
use App\Services\PortfolioProviders\Enums\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @covers \App\Services\PortfolioProviders\Adapters\ArtworkAdapter
 */
class ArtworkAdapterTest extends TestCase
{
    /**
     * @covers \App\Services\PortfolioProviders\Adapters\ArtworkAdapter::convertFromSource()
     */
    public function testCanConvertFromSource(): void
    {
        $dto = new ArtworkDto(
            title: 'My image',
            description: 'My description',
            imageUrl: 'path/to/image.jpg',
            publishedAt: time(),
            externalId: '123',
            provider: Provider::DeviantArt,
            isFeatured: true,
            categories: ['Digital Art']
        );

        $artwork = (new ArtworkAdapter($dto))->convertFromSource();

        $this->assertSame('My image', $artwork->images[0]->title);
        $this->assertSame('My description', $artwork->images[0]->description);
        $this->assertSame($dto->publishedAt, $artwork->published_at->timestamp);
        $this->assertTrue($artwork->is_featured);
        $this->assertSame(['deviantart' => '123'], $artwork->external_ids);
    }
}
