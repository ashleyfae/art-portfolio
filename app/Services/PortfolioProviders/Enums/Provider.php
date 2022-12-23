<?php
/**
 * Provider.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Services\PortfolioProviders\Enums;

use App\Services\PortfolioProviders\Contracts\PortfolioProvider;
use App\Services\PortfolioProviders\DeviantArt;

enum Provider: string
{
    case DeviantArt = 'deviantart';

    public function getProviderClassInstance(): PortfolioProvider
    {
        return match($this) {
            Provider::DeviantArt => app(DeviantArt::class),
        };
    }
}
