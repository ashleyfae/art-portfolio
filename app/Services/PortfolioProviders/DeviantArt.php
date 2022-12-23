<?php
/**
 * DeviantArt.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Services\PortfolioProviders;

use App\Exceptions\RequestFailedException;
use App\Models\AccessToken;
use App\Services\PortfolioProviders\Contracts\PortfolioProvider;
use App\Services\PortfolioProviders\DataTransferObjects\Artwork;
use App\Services\PortfolioProviders\Enums\Provider;
use App\Services\PortfolioProviders\Http\Requests\OAuthRequest;
use Illuminate\Support\Facades\Config;
use League\OAuth2\Client\Provider\GenericProvider;

class DeviantArt implements PortfolioProvider
{
    public function __construct(protected OAuthRequest $request)
    {

    }

    public function getProvider(): Provider
    {
        return Provider::DeviantArt;
    }

    public function getOauthProvider(): GenericProvider
    {
        return new GenericProvider([
            'clientId' => Config::get('services.deviantart.oauth.client_id'),
            'clientSecret' => Config::get('services.deviantart.oauth.client_secret'),
            'redirectUri' => route('deviantart.redirect'),
            'urlAuthorize' => 'https://www.deviantart.com/oauth2/authorize?scope=browse',
            'urlAccessToken' => 'https://www.deviantart.com/oauth2/token',
            'urlResourceOwnerDetails' => 'https://www.deviantart.com/oauth2/resource',
        ]);
    }

    /**
     * @return array|Artwork[]
     * @throws RequestFailedException
     */
    public function getEntries(AccessToken $accessToken, int $offset, int $limit): array
    {
        $response = $this->request
            ->withToken($accessToken)
            ->get('https://www.deviantart.com/api/v1/oauth2/gallery/all', [
            'with_session' => false,
            'mature_content' => true,
            'offset' => $offset,
            'limit' => $limit,
        ]);

        if (! $response->ok()) {
            throw new RequestFailedException();
        }

        $body = $response->json();

        if (empty($body['results'])) {
            return [];
        }

        return app(DeviantArtGalleryFormatter::class)
            ->setGalleryResults($body['results'])
            ->setAccessToken($accessToken)
            ->getFormattedEntries();
    }
}
