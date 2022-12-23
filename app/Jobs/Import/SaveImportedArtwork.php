<?php

namespace App\Jobs\Import;

use App\Exceptions\DownloadImageException;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\User;
use App\Services\PortfolioProviders\Adapters\ArtworkAdapter;
use App\Services\PortfolioProviders\DataTransferObjects\Artwork as ArtworkDto;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SaveImportedArtwork implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public User $user, public ArtworkDto $artworkDto)
    {
        //
    }

    public function uniqueId(): ?string
    {
        return $this->artworkDto->externalId;
    }

    /**
     * Execute the job.
     *
     * @throws DownloadImageException
     */
    public function handle()
    {
        $artwork = (new ArtworkAdapter($this->artworkDto))->convertFromSource();
        $artwork->image_path = $this->downloadImage();

        /** @var Artwork $artwork */
        $artwork = $this->user->artworks()->save($artwork);

        foreach($this->artworkDto->categories as $categoryName) {
            $category = Category::firstOrCreate([
                'name' => $categoryName,
            ]);

            $artwork->categories()->save($category);
        }
    }

    /**
     * @throws DownloadImageException
     */
    protected function downloadImage(): string
    {
        $uniqueId = $this->artworkDto->externalId ?: Str::uuid()->toString();

        $fileName = date('Y/m', $this->artworkDto->publishedAt).'/'.$uniqueId.'.jpg';

        if (Storage::disk('public')->put($fileName, $this->getFileContents())) {
            return $fileName;
        }  else {
            throw new DownloadImageException();
        }
    }

    /**
     * @throws DownloadImageException
     */
    protected function getFileContents(): string
    {
        return file_get_contents($this->artworkDto->imageUrl) ?: throw new DownloadImageException();
    }
}
