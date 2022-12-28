<?php

namespace App\Console\Commands\ImportProviders;

use App\Actions\Import\ImportPortfolio;
use App\Models\User;
use App\Services\PortfolioProviders\Contracts\PortfolioProvider;
use App\Services\PortfolioProviders\Repositories\AccessTokenRepository;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portfolio:import {email?} {--limit=10} {--offset=0} {--nopaging} {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports a portfolio';

    public function __construct(
        protected PortfolioProvider $portfolioProvider,
        protected AccessTokenRepository $accessTokenRepository,
        protected ImportPortfolio $importPortfolio,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if (! $email = $this->argument('email')) {
            $email = $this->ask('User email address?');
        }

        $user = User::where('email', $email)->firstOrFail();

        $this->importPortfolio
            ->setOffset((int) $this->option('offset'))
            ->setLimit((int) $this->option('limit'))
            ->setPaginate((bool) ! $this->option('nopaging'))
            ->setIsDryRun((bool) $this->option('dry-run'))
            ->setCommand($this)
            ->runForUser($user);

        $this->line('Import complete.');

        return Command::SUCCESS;
    }
}
