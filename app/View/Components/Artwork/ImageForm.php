<?php

namespace App\View\Components\Artwork;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class ImageForm extends Component
{
    public string $uniqueId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public ?Image $image, public bool $primary = true, public bool $disabled = false, public int $number = 0)
    {
        $this->uniqueId = Str::uuid()->toString();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.artwork.image-form');
    }
}
