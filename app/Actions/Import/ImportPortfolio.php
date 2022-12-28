<?php
/**
 * ImportPortfolio.php
 *
 * @package   art
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   MIT
 */

namespace App\Actions\Import;

use App\Jobs\Import\SaveImportedArtwork;
use App\Models\User;
use App\Services\PortfolioProviders\Contracts\PortfolioProvider;
use App\Services\PortfolioProviders\Repositories\AccessTokenRepository;
use Illuminate\Console\Command;

class ImportPortfolio
{
    protected User $user;
    protected int $offset = 0;
    protected int $limit = 24;
    protected bool $paginate = true;
    protected bool $isDryRun = false;
    protected bool $completed = false;
    protected ?Command $command = null;

    public function __construct(
        protected PortfolioProvider $portfolioProvider,
        protected AccessTokenRepository $accessTokenRepository
    ) {

    }

    public function setOffset(int $offset): static
    {
        $this->offset = $offset;

        return $this;
    }

    public function setLimit(int $limit): static
    {
        $this->limit = $limit;

        return $this;
    }

    public function setPaginate(bool $paginate): static
    {
        $this->paginate = $paginate;

        return $this;
    }

    public function setIsDryRun(bool $isDryRun): static
    {
        $this->isDryRun = $isDryRun;

        return $this;
    }

    public function setCommand(Command $command): static
    {
        $this->command = $command;

        return $this;
    }

    public function runForUser(User $user): void
    {
        $this->user = $user;

        while(! $this->completed) {
            $batch = $this->importBatch();
            $this->offset += $this->limit;

            if ($this->isDryRun) {
                dd($batch);
            }

            if (! $this->paginate) {
                return;
            }
        }
    }

    protected function importBatch(): array
    {
        $this->log(sprintf('Processing batch - offset: %d', $this->offset));

        $artworks = $this->portfolioProvider->getEntries(
            accessToken: $this->accessTokenRepository->getProviderTokenForUser($this->user, $this->portfolioProvider->getProvider()),
            offset: $this->offset,
            limit: $this->limit
        );

        if (empty($artworks)) {
            $this->completed = true;

            $this->log('-- No more artworks found.');

            return $artworks;
        }

        if (! $this->isDryRun) {
            $this->log('-- Creating insert job.');

            $this->createInsertJob($artworks);
        }

        return $artworks;
    }

    protected function createInsertJob(array $artworks): void
    {
        foreach($artworks as $artwork) {
            SaveImportedArtwork::dispatch($this->user, $artwork);
        }
    }

    protected function log(string $message): void
    {
        if ($this->command instanceof Command) {
            $this->command->line($message);
        }
    }
}
