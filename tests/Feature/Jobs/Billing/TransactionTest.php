<?php

declare(strict_types=1);

namespace Tests\Feature\Jobs\Billing;

use App\Constants\Config\FlagConstants;
use App\Jobs\SendDiscordNotificationJob;
use App\Models\Billing\Transaction;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * Class TransactionTest.
 */
class TransactionTest extends TestCase
{
    /**
     * When a transaction is created, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testTransactionCreatedSendsDiscordNotification(): void
    {
        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        Transaction::factory()->createOne();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }

    /**
     * When a transaction is deleted, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testTransactionDeletedSendsDiscordNotification(): void
    {
        $transaction = Transaction::factory()->createOne();

        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        $transaction->delete();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }

    /**
     * When a transaction is restored, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testTransactionRestoredSendsDiscordNotification(): void
    {
        $transaction = Transaction::factory()->createOne();

        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        $transaction->restore();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }

    /**
     * When a transaction is updated, a SendDiscordNotification job shall be dispatched.
     *
     * @return void
     */
    public function testTransactionUpdatedSendsDiscordNotification(): void
    {
        $transaction = Transaction::factory()->createOne();

        Config::set(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, true);
        Bus::fake(SendDiscordNotificationJob::class);

        $changes = Transaction::factory()->makeOne();

        $transaction->fill($changes->getAttributes());
        $transaction->save();

        Bus::assertDispatched(SendDiscordNotificationJob::class);
    }
}
