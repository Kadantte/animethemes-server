<?php

declare(strict_types=1);

namespace Tests\Feature\Jobs\Wiki;

use App\Constants\Config\FlagConstants;
use App\Jobs\SendDiscordNotificationJob;
use App\Models\Wiki\Studio;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * Class StudioTest.
 */
class StudioTest extends TestCase
{
    /**
     * When a studio is created, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testStudioCreatedSendsDiscordNotification(): void
    {
        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        Studio::factory()->createOne();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }

    /**
     * When a studio is deleted, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testStudioDeletedSendsDiscordNotification(): void
    {
        $studio = Studio::factory()->createOne();

        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        $studio->delete();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }

    /**
     * When a studio is restored, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testStudioRestoredSendsDiscordNotification(): void
    {
        $studio = Studio::factory()->createOne();

        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        $studio->restore();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }

    /**
     * When a studio is updated, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testStudioUpdatedSendsDiscordNotification(): void
    {
        $studio = Studio::factory()->createOne();

        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        $changes = Studio::factory()->makeOne();

        $studio->fill($changes->getAttributes());
        $studio->save();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }
}
