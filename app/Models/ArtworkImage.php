<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $artwork_id
 * @property int $image_id
 * @property bool $is_primary
 *
 * @mixin Builder
 */
class ArtworkImage extends Pivot
{
    use HasFactory;

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
