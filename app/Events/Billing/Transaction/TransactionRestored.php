<?php

declare(strict_types=1);

namespace App\Events\Billing\Transaction;

use App\Events\Base\Admin\AdminRestoredEvent;
use App\Models\Billing\Transaction;

/**
 * Class TransactionRestored.
 *
 * @extends AdminRestoredEvent<Transaction>
 */
class TransactionRestored extends AdminRestoredEvent
{
    /**
     * Create a new event instance.
     *
     * @param  Transaction  $transaction
     */
    public function __construct(Transaction $transaction)
    {
        parent::__construct($transaction);
    }

    /**
     * Get the model that has fired this event.
     *
     * @return Transaction
     */
    public function getModel(): Transaction
    {
        return $this->model;
    }

    /**
     * Get the description for the Discord message payload.
     *
     * @return string
     */
    protected function getDiscordMessageDescription(): string
    {
        return "Transaction '**{$this->getModel()->getName()}**' has been restored.";
    }
}
