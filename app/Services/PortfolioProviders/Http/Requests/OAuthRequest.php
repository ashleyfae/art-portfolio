<?php
/**
 * OAuthRequest.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Services\PortfolioProviders\Http\Requests;

use App\Models\AccessToken;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class OAuthRequest
{
    public function __construct()
    {

    }

    public function withToken(AccessToken $accessToken): PendingRequest
    {
        $oauthToken = $accessToken->getOauthToken();

        if ($oauthToken->hasExpired()) {
            $oauthToken = $accessToken->provider->getProviderClassInstance()->getOauthProvider()->getAccessToken('refresh_token', [
                'refresh_token' => $oauthToken->getRefreshToken(),
            ]);

            $accessToken->access_token = $oauthToken->getToken();
            $accessToken->expires_at = $oauthToken->getExpires();
            $accessToken->refresh_token = $oauthToken->getRefreshToken();
            $accessToken->save();
        }

        return Http::withToken($oauthToken->getToken());
    }
}
