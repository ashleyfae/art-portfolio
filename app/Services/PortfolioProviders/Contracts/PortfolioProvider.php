<?php
/**
 * PortfolioProvider.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Services\PortfolioProviders\Contracts;

use App\Models\AccessToken;
use App\Models\Artwork;
use App\Services\PortfolioProviders\Enums\Provider;
use League\OAuth2\Client\Provider\GenericProvider;

interface PortfolioProvider
{
    public function getProvider() : Provider;

    public function getOauthProvider() : GenericProvider;

    /**
     * @return Artwork[]
     */
    public function getEntries(AccessToken $accessToken, int $offset, int $limit) : array;
}
