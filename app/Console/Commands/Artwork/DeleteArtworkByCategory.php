<?php
/**
 * DeleteArtworkByCategory.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Console\Commands\Artwork;

use App\Actions\Artwork\DeleteArtwork;
use App\Models\Category;

class DeleteArtworkByCategory
{
    const PER_PAGE = 30;

    protected bool $isComplete = false;

    public function __construct(protected DeleteArtwork $deleteArtwork)
    {

    }

    public function execute(Category $category): int
    {
        $numberDeleted = 0;

        while(! $this->isComplete) {
            $artworks = $category->artworks()->take(static::PER_PAGE)->get();

            if ($artworks->isEmpty()) {
                $this->isComplete = true;
                break;
            }

            foreach($artworks as $artwork) {
                $this->deleteArtwork->execute($artwork);

                $numberDeleted++;
            }
        }

        return $numberDeleted;
    }
}
