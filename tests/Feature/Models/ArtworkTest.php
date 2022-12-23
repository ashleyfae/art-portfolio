<?php

namespace Tests\Feature\Models;

use App\Models\Artwork;
use App\Models\Image;
use Tests\TestCase;

/**
 * @covers \App\Models\Artwork
 */
class ArtworkTest extends TestCase
{
    /**
     * @covers \App\Models\Artwork::primaryImage()
     */
    public function testPrimaryImageRelationship(): void
    {
        /** @var Image $primaryImage */
        $primaryImage = Image::factory()->create();

        /** @var Artwork $artwork */
        $artwork = Artwork::factory()
            ->hasAttached(
                Image::factory()->count(3),
                ['is_primary' => false]
            )
            ->create();

        // At this point there should be no primary image.
        $this->assertNull($artwork->primaryImage);
        $this->assertSame(3, $artwork->images()->count());

        $artwork->images()->attach($primaryImage->id, ['is_primary' => true]);

        $artwork->refresh();

        $this->assertSame($primaryImage->id, $artwork->primaryImage->id);
    }
}
