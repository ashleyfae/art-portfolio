<?php

namespace App\Http\Controllers\ImportProviders\DeviantArt;

use App\Http\Controllers\Controller;
use App\Http\Requests\OAuthRedirectRequest;
use App\Services\PortfolioProviders\DeviantArt;
use App\Services\PortfolioProviders\Repositories\AccessTokenRepository;
use Illuminate\Http\Request;

class DeviantArtRedirectController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(OAuthRedirectRequest $request, DeviantArt $deviantArt, AccessTokenRepository $repository)
    {
        $provider = $deviantArt->getOauthProvider();

        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $request->input('code'),
        ]);

        $repository->saveTokenToUser(
            $request->user(),
            $deviantArt->getProvider(),
            $accessToken
        );

        dump("Token: {$accessToken->getToken()}");
        dump("Refresh Token: {$accessToken->getRefreshToken()}");
        dump("Expires at: {$accessToken->getExpires()}");
        dd();
    }
}
