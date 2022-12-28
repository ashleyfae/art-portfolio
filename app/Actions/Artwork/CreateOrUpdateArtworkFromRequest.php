<?php
/**
 * CreateArtworkFromRequest.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Actions\Artwork;

use App\Exceptions\MissingArtworkObjectException;
use App\Http\Requests\StoreArtworkRequest;
use App\Http\Requests\UpdateArtworkRequest;
use App\Models\Artwork;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class CreateOrUpdateArtworkFromRequest
{
    protected Artwork $artwork;
    protected StoreArtworkRequest|UpdateArtworkRequest $request;
    protected array $data;

    public function __construct(protected CreateOrUpdateImageFromRequest $createOrUpdateImageFromRequest)
    {

    }

    public function setArtwork(Artwork $artwork): static {
        $this->artwork = $artwork;

        return $this;
    }

    /**
     * @throws MissingArtworkObjectException
     */
    public function execute(StoreArtworkRequest|UpdateArtworkRequest $request): Artwork
    {
        $this->request = $request;
        $this->data = $request->validated();

        DB::transaction(function() {
            $this->artwork = $this->updateOrCreateArtwork();
            $this->artwork->images()->sync($this->createOrUpdateImages());
            $this->artwork->categories()->sync($this->createOrUpdateCategories());
        });

        if (! isset($this->artwork)) {
            throw new MissingArtworkObjectException();
        }

        return $this->artwork;
    }

    /**
     * @throws MissingArtworkObjectException
     */
    protected function updateOrCreateArtwork() : Artwork
    {
        if ($this->request instanceof UpdateArtworkRequest) {
            $artwork = $this->getArtwork();
        } else {
            $artwork = $this->createArtwork();
        }

        $artwork->is_featured = ! empty($this->data['is_featured']);
        $artwork->published_at = $this->data['published_at'] ?? date('Y-m-d H:i:s');

        $artwork->save();

        return $artwork;
    }

    protected function createArtwork() : Artwork
    {
        return $this->request->user()->artworks()->make();
    }

    /**
     * @throws MissingArtworkObjectException
     */
    protected function getArtwork() : Artwork
    {
        if (! isset($this->artwork)) {
            throw new MissingArtworkObjectException();
        }

        return $this->artwork;
    }

    protected function createOrUpdateImages(): array
    {
        $images = [];
        $requestImages = array_filter($this->data['images'] ?? []);

        if (empty($requestImages)) {
            return $images;
        }

        foreach($requestImages as $index => $requestImage) {
            $image = $this->updateOrCreateImage($requestImage, $index);

            $images[$image->id] = [
                'is_primary' => ! empty($requestImage['primary']),
            ];
        }

        return $images;
    }

    protected function updateOrCreateImage(array $requestImage, int|string $index): Image
    {
        return $this->createOrUpdateImageFromRequest->setData($requestImage)->execute($this->request, $index);
    }

    protected function createOrUpdateCategories(): array
    {
        $categories = [];
        $requestCats = array_filter($this->data['categories'] ?? []);

        if (empty($requestCats)) {
            return $categories;
        }

        foreach($requestCats as $requestCat) {
            try {
                $category = $this->getOrCreateCategory($requestCat);

                $categories[] = $category->id;
            } catch(\Exception $e) {
                continue;
            }
        }

        return $categories;
    }

    protected function getOrCreateCategory(string|int $categoryIdOrName): Category
    {
        if (is_numeric($categoryIdOrName)) {
            return Category::findOrFail($categoryIdOrName);
        } else {
            return Category::firstOrCreate(['name' => $categoryIdOrName]);
        }
    }
}
