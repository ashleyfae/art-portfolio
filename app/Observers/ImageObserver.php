<?php

namespace App\Observers;

use App\Actions\Images\SetImageDimensions;
use App\DataTransferObjects\ImageDimensions;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageObserver
{
    /**
     * Handle the Image "created" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function created(Image $image)
    {
        //
    }

    /**
     * Handle the Image "updated" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function updated(Image $image)
    {
        //
    }

    public function saving(Image $image)
    {
        if ($image->image_path) {
            app(SetImageDimensions::class)->parseAndSet($image);
        }
    }

    /**
     * Handle the Image "deleted" event.
     *
     * @param  \App\Models\Image  $image
     * @return void
     */
    public function deleted(Image $image)
    {
        Storage::delete($image->image_path);
    }
}
