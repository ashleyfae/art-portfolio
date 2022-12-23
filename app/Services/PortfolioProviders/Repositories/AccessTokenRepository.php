<?php
/**
 * SaveAccessToken.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Services\PortfolioProviders\Repositories;

use App\Models\AccessToken;
use App\Models\User;
use App\Services\PortfolioProviders\Enums\Provider;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccessTokenRepository
{
    public function saveTokenToUser(User $user, Provider $provider, \League\OAuth2\Client\Token\AccessToken $oauthToken): AccessToken
    {
        try {
            $token = $this->getProviderTokenForUser($user, $provider);
        } catch(ModelNotFoundException $e) {
            $token = new AccessToken();
            $token->user()->associate($user);
        }

        $token->access_token = $oauthToken->getToken();
        $token->refresh_token = $oauthToken->getRefreshToken();
        $token->expires_at = $oauthToken->getExpires();
        $token->provider = $provider;

        $token->save();

        return $token;
    }

    /**
     * @param  User  $user
     * @param  Provider  $provider
     *
     * @return AccessToken
     * @throws ModelNotFoundException
     */
    public function getProviderTokenForUser(User $user, Provider $provider): AccessToken
    {
        return $user->accessTokens()->where('provider', $provider->value)->firstOrFail();
    }
}
