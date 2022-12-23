<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property string|null $title
 * @property string|null $description
 * @property string $image_path
 * @property array|null $external_ids
 * @property bool $is_featured
 * @property Carbon $published_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Category[]|Collection $categories
 *
 * @mixin Builder
 */
class Artwork extends Model
{
    use HasFactory, BelongsToUser;

    protected $casts = [
        'published_at' => 'datetime',
        'external_ids' => 'array',
        'is_featured' => 'boolean',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
