<?php
/**
 * CreateOrUpdateImageFromRequest.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Actions\Artwork;

use App\Http\Requests\StoreArtworkRequest;
use App\Http\Requests\UpdateArtworkRequest;
use App\Models\Image;

class CreateOrUpdateImageFromRequest
{
    protected array $data = [];
    protected StoreArtworkRequest|UpdateArtworkRequest $request;

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function execute(StoreArtworkRequest|UpdateArtworkRequest $request, int|string $index) : Image
    {
        $this->request = $request;

        $image = $this->getOrCreateImage();
        $image->title = $this->data['title'] ?? null;
        $image->description = $this->data['description'] ?? null;

        if ($file = $this->request->file("images.{$index}.image")) {
            $image->image_path = $file->store('');
        }

        $image->save();

        return $image;
    }

    protected function getOrCreateImage(): Image
    {
        if (! empty($this->data['id'])) {
            return Image::findOrFail((int) $this->data['id']);
        } else {
            return Image::make();
        }
    }
}
