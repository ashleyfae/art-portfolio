<?php

namespace Tests\Feature\Jobs\Import;

use App\Jobs\Import\SaveImportedArtwork;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\Image;
use App\Models\User;
use App\Services\PortfolioProviders\DataTransferObjects\Artwork as ArtworkDto;
use App\Services\PortfolioProviders\Enums\Provider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Mockery\MockInterface;
use Tests\TestCase;

class SaveImportedArtworkTest extends TestCase
{
    use RefreshDatabase;

    protected function getArtworkDto(): ArtworkDto
    {
        return new ArtworkDto(
            title: 'My Artwork',
            description: 'Description',
            imageUrl: null,
            publishedAt: strtotime('-1 hour'),
            externalId: 'external-123',
            provider: Provider::DeviantArt,
            isFeatured: true,
            categories: ['Digital Art']
        );
    }

    /**
     * @covers \App\Jobs\Import\SaveImportedArtwork::handle()
     * @dataProvider providerCanHandle
     */
    public function testCanHandle(bool $categoryAlreadyExists): void
    {
        $user = User::factory()->create();
        $artworkDto = $this->getArtworkDto();

        if ($categoryAlreadyExists) {
            Category::factory()->create(['name' => 'Digital Art']);
            $this->assertDatabaseHas(Category::class, ['name' => 'Digital Art']);
        } else {
            $this->assertDatabaseMissing(Category::class, ['name' => 'Digital Art']);
        }

        $this->assertDatabaseCount(Artwork::class, 0);
        $this->assertDatabaseMissing(Image::class, [
            'title' => 'My Artwork',
        ]);

        /** @var SaveImportedArtwork&MockInterface $job */
        $job = $this->partialMock(SaveImportedArtwork::class, function(MockInterface $mock) {
            $mock->shouldAllowMockingProtectedMethods();

            $mock->expects('downloadImage')
                ->once()
                ->andReturn('path/to/image.jpg');
        });

        $job->user = $user;
        $job->artworkDto = $artworkDto;

        $job->handle();

        $this->assertDatabaseCount(Artwork::class, 1);
        $this->assertDatabaseHas(Image::class, [
            'title' => 'My Artwork',
            'description' => 'Description',
            'image_path' => 'path/to/image.jpg',
        ]);

        $this->assertDatabaseHas(Category::class, ['name' => 'Digital Art']);
        $this->assertDatabaseCount(Category::class, 1);
    }

    /** @see testCanHandle */
    public function providerCanHandle(): \Generator
    {
        yield [true];
        yield [false];
    }

    /**
     * @covers \App\Jobs\Import\SaveImportedArtwork::downloadImage()
     * @throws \Exception
     */
    public function testCanDownloadImage(): void
    {
        Storage::fake('public');

        $filePath = date('Y/m', $this->getArtworkDto()->publishedAt) . '/' . $this->getArtworkDto()->externalId.'.jpg';

        Storage::disk('public')->assertMissing($filePath);

        /** @var SaveImportedArtwork&MockInterface $job */
        $job = $this->partialMock(SaveImportedArtwork::class, function(MockInterface $mock) {
            $mock->shouldAllowMockingProtectedMethods();

            $mock->expects('getFileContents')
                ->once()
                ->andReturn('data');
        });

        $job->artworkDto = $this->getArtworkDto();

        $this->invokeInaccessibleMethod($job, 'downloadImage');

        Storage::disk('public')->assertExists($filePath);
    }
}
