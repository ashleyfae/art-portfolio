<?php
/**
 * ListArtwork.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Actions\Artwork;

use App\DataTransferObjects\FilterArtwork;
use App\Models\Artwork;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ListArtwork
{
    public function list(FilterArtwork $filter): LengthAwarePaginator
    {
        return Artwork::query()
            ->with(['primaryImage'])
            ->orderByDesc('published_at')
            ->when(! is_null($filter->year), fn(Builder $query) => $query->whereYear('published_at', $filter->year))
            ->when(! $filter->showAll, fn(Builder $query) => $query->where('is_featured', true))
            ->paginate(40);
    }
}
