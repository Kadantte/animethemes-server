<?php

declare(strict_types=1);

namespace Tests\Feature\Jobs\Wiki;

use App\Constants\Config\FlagConstants;
use App\Jobs\SendDiscordNotificationJob;
use App\Models\Wiki\Video;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * Class VideoTest.
 */
class VideoTest extends TestCase
{
    /**
     * When a video is created, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testVideoCreatedSendsDiscordNotification(): void
    {
        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        Video::factory()->createOne();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }

    /**
     * When a video is deleted, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testVideoDeletedSendsDiscordNotification(): void
    {
        $video = Video::factory()->createOne();

        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        $video->delete();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }

    /**
     * When a video is restored, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testVideoRestoredSendsDiscordNotification(): void
    {
        $video = Video::factory()->createOne();

        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        $video->restore();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }

    /**
     * When a video is updated, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testVideoUpdatedSendsDiscordNotification(): void
    {
        $video = Video::factory()->createOne();

        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        $changes = Video::factory()->makeOne();

        $video->fill($changes->getAttributes());
        $video->save();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }
}
