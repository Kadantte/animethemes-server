<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Billing;

use App\Enums\Models\Billing\Service;
use App\Models\Billing\Transaction;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * Class TransactionTest.
 */
class TransactionTest extends TestCase
{
    /**
     * The service attribute of a transaction shall be cast to a Service enum instance.
     *
     * @return void
     */
    public function testCastsServiceToEnum(): void
    {
        $transaction = Transaction::factory()->createOne();

        $service = $transaction->service;

        static::assertInstanceOf(Service::class, $service);
    }

    /**
     * Transaction shall be auditable.
     *
     * @return void
     */
    public function testAuditable(): void
    {
        Config::set('audit.console', true);

        $transaction = Transaction::factory()->createOne();

        static::assertEquals(1, $transaction->audits()->count());
    }

    /**
     * Transactions shall be nameable.
     *
     * @return void
     */
    public function testNameable(): void
    {
        $transaction = Transaction::factory()->createOne();

        static::assertIsString($transaction->getName());
    }
}
