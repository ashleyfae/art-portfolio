<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use App\Models\Traits\HasRoute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property array|null $external_ids
 * @property bool $is_featured
 * @property Carbon $published_at
 * @property string $uuid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Image[]|Collection $images
 * @property Image|null $primaryImage
 * @property Image[]|Collection $galleryImages
 * @property Category[]|Collection $categories
 *
 * @mixin Builder
 */
class Artwork extends Model
{
    use HasFactory, BelongsToUser, HasRoute;

    protected $casts = [
        'published_at' => 'datetime',
        'external_ids' => 'array',
        'is_featured' => 'boolean',
    ];

    protected $fillable = [
        'is_featured',
        'published_at',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class)
            ->with('is_primary');
    }

    public function primaryImage(): HasOneThrough
    {
        return $this->hasOneThrough(
            Image::class,
            ArtworkImage::class,
            'artwork_id',
            'id',
            null,
            'image_id'
        )
            ->where('is_primary', true);
    }

    public function galleryImages() : BelongsToMany
    {
        return $this->images()->wherePivot('is_primary', false);
    }
}
