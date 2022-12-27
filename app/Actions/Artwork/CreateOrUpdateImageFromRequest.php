<?php
/**
 * CreateOrUpdateImageFromRequest.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Actions\Artwork;

use App\Exceptions\ImageUploadException;
use App\Http\Requests\StoreArtworkRequest;
use App\Http\Requests\UpdateArtworkRequest;
use App\Models\Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;

class CreateOrUpdateImageFromRequest
{
    protected array $data = [];
    protected StoreArtworkRequest|UpdateArtworkRequest $request;

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @throws ImageUploadException
     */
    public function execute(StoreArtworkRequest|UpdateArtworkRequest $request, int|string $index) : Image
    {
        $this->request = $request;

        $image = $this->getOrCreateImage();
        $image->title = $this->data['title'] ?? null;
        $image->description = $this->data['description'] ?? null;

        if ($file = $this->request->file("images.{$index}.image")) {
            $image->image_path = $file->storePublicly(date('Y/m'));

            if (empty($image->image_path) || ! Storage::exists($image->image_path)) {
                throw new ImageUploadException();
            }
        }

        $image->save();

        return $image;
    }

    /**
     * @throws ModelNotFoundException
     */
    protected function getOrCreateImage(): Image
    {
        if (! empty($this->data['id'])) {
            return Image::findOrFail((int) $this->data['id']);
        } else {
            return Image::make();
        }
    }
}
