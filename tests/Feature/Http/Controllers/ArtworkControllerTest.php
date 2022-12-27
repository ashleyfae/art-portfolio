<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Artwork;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\ArtworkController
 */
class ArtworkControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @covers \App\Http\Controllers\ArtworkController::__construct()
     * @covers \App\Http\Controllers\ArtworkController::create()
     */
    public function testGuestCannotCreateArtwork(): void
    {
        $response = $this->get(route('artworks.create'));

        $response->assertRedirectToRoute('login');
    }

    /**
     * @covers \App\Http\Controllers\ArtworkController::__construct()
     * @covers \App\Http\Controllers\ArtworkController::create()
     */
    public function testLoggedInUserCanCreateArtwork(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('artworks.create'));

        $response->assertOk();
        $response->assertViewIs('artwork.create');
    }

    /**
     * @covers \App\Http\Controllers\ArtworkController::__construct()
     * @covers \App\Http\Controllers\ArtworkController::store()
     */
    public function testGuestCannotStoreArtwork(): void
    {
        $response = $this->post(route('artworks.store'));

        $response->assertRedirectToRoute('login');
    }

    /**
     * @covers \App\Http\Controllers\ArtworkController::__construct()
     * @covers \App\Http\Controllers\ArtworkController::store()
     */
    public function testLoggedInUserCanStoreArtwork(): void
    {
        Storage::fake();

        /** @var User $user */
        $user = User::factory()->create();

        $this->assertDatabaseMissing(Artwork::class, ['user_id' => $user->id]);

        $primaryImage = UploadedFile::fake()->image('primary.jpg')->mimeType('image/jpeg');
        $secondaryImage = UploadedFile::fake()->image('secondary.jpg')->mimeType('image/jpeg');

        $response = $this->actingAs($user)->post(route('artworks.store', [
            'images' => [
                [
                    'image' => $primaryImage,
                    'title' => 'Primary Title',
                    'description' => '',
                    'alt_text' => 'Alt text',
                    'primary' => '1',
                ],
                [
                    'image' => $secondaryImage,
                    'title' => 'Process',
                    'description' => '',
                    'alt_text' => '',
                ]
            ],
            'is_featured' => '1',
            'published_at' => '2022-12-27 15:16:00',
        ]));

        // don't know why image validation is failing
        
        $this->assertDatabaseHas(Artwork::class, ['user_id' => $user->id]);

        $response->assertRedirectToRoute('artworks.show');

        Storage::disk('public')->assertExists($primaryImage->hashName());
        Storage::disk('public')->assertExists($secondaryImage->hashName());
    }
}
