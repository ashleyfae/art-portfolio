<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property ?string $title
 * @property ?string $description
 * @property ?string $alt_text
 * @property string $image_path
 * @property ?int $width
 * @property ?int $height
 * @property ?int $bytes
 * @property ?string $mime
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @mixin Builder
 */
class Image extends Model
{
    use HasFactory;

    public function artworks(): BelongsToMany
    {
        return $this->belongsToMany(Artwork::class);
    }
}
