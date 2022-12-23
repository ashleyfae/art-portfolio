<?php

namespace Tests\Feature\Services\PortfolioProviders\Repositories;

use App\Models\AccessToken;
use App\Models\User;
use App\Services\PortfolioProviders\Enums\Provider;
use App\Services\PortfolioProviders\Repositories\AccessTokenRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\TestCase;

/**
 * @covers \App\Services\PortfolioProviders\Repositories\AccessTokenRepository
 */
class AccessTokenRepositoryTest extends TestCase
{
    /**
     * @covers \App\Services\PortfolioProviders\Repositories\AccessTokenRepository::getProviderTokenForUser()
     */
    public function testCanGetProviderTokenForUser(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var AccessToken $accessToken */
        $accessToken = AccessToken::factory()
            ->create([
                'user_id' => $user->id,
                'provider' => Provider::DeviantArt->value,
            ]);

        $this->assertSame(
            $accessToken->id,
            app(AccessTokenRepository::class)->getProviderTokenForUser($user, Provider::DeviantArt)->id
        );
    }

    /**
     * @covers \App\Services\PortfolioProviders\Repositories\AccessTokenRepository::getProviderTokenForUser()
     */
    public function testGetProviderTokenForUserThrowsException(): void
    {
        $user = User::factory()->create();

        $this->expectException(ModelNotFoundException::class);

        app(AccessTokenRepository::class)->getProviderTokenForUser($user, Provider::DeviantArt);
    }
}
