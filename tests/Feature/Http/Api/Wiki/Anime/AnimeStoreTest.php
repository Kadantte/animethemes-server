<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Api\Wiki\Anime;

use App\Enums\Models\Wiki\AnimeSeason;
use App\Models\Auth\User;
use App\Models\Wiki\Anime;
use Illuminate\Foundation\Testing\WithoutEvents;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Class AnimeStoreTest.
 */
class AnimeStoreTest extends TestCase
{
    use WithoutEvents;

    /**
     * The Anime Store Endpoint shall be protected by sanctum.
     *
     * @return void
     */
    public function testProtected(): void
    {
        $anime = Anime::factory()->makeOne();

        $response = $this->post(route('api.anime.store', $anime->toArray()));

        $response->assertUnauthorized();
    }

    /**
     * The Anime Store Endpoint shall require name, season, slug & year fields.
     *
     * @return void
     */
    public function testRequiredFields(): void
    {
        $user = User::factory()->withPermission('create anime')->createOne();

        Sanctum::actingAs($user);

        $response = $this->post(route('api.anime.store'));

        $response->assertJsonValidationErrors([
            Anime::ATTRIBUTE_NAME,
            Anime::ATTRIBUTE_SEASON,
            Anime::ATTRIBUTE_SLUG,
            Anime::ATTRIBUTE_YEAR,
        ]);
    }

    /**
     * The Anime Store Endpoint shall create an anime.
     *
     * @return void
     */
    public function testCreate(): void
    {
        $parameters = array_merge(
            Anime::factory()->raw(),
            [Anime::ATTRIBUTE_SEASON => AnimeSeason::getRandomInstance()->description],
        );

        $user = User::factory()->withPermission('create anime')->createOne();

        Sanctum::actingAs($user);

        $response = $this->post(route('api.anime.store', $parameters));

        $response->assertCreated();
        static::assertDatabaseCount(Anime::TABLE, 1);
    }
}
