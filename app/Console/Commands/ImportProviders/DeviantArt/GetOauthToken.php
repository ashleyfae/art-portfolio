<?php

namespace App\Console\Commands\ImportProviders\DeviantArt;

use App\Services\PortfolioProviders\DeviantArt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use League\OAuth2\Client\Provider\GenericProvider;

class GetOauthToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'da:token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets a DeviantArt oAuth Token.';

    public function __construct(protected DeviantArt $deviantArt)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $provider = $this->deviantArt->getOauthProvider();

        $this->line($provider->getAuthorizationUrl());

        return Command::SUCCESS;
    }
}
