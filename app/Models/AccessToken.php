<?php

namespace App\Models;

use App\Models\Traits\BelongsToUser;
use App\Services\PortfolioProviders\Enums\Provider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property Provider $provider
 * @property string $access_token
 * @property Carbon $expires_at
 * @property string $refresh_token
 *
 * @mixin Builder
 */
class AccessToken extends Model
{
    use HasFactory, BelongsToUser;

    protected $casts = [
        'provider' => Provider::class,
        'access_token' => 'encrypted',
        'refresh_token' => 'encrypted',
        'expires_at' => 'datetime',
    ];

    public function getOauthToken(): \League\OAuth2\Client\Token\AccessToken
    {
        return new \League\OAuth2\Client\Token\AccessToken([
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
            'expires' => $this->expires_at->timestamp,
        ]);
    }
}
