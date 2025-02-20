<?php

declare(strict_types=1);

namespace App\Console\Commands\Billing\Balance;

use App\Concerns\Repositories\Billing\ReconcilesBalanceRepositories;
use App\Console\Commands\Billing\ServiceReconcileCommand;
use App\Contracts\Repositories\Repository;
use App\Enums\Models\Billing\Service;
use App\Models\BaseModel;
use App\Repositories\Eloquent\Billing\DigitalOceanBalanceRepository as DigitalOceanDestinationRepository;
use App\Repositories\Service\DigitalOcean\Billing\DigitalOceanBalanceRepository as DigitalOceanSourceRepository;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

/**
 * Class BalanceReconcileCommand.
 */
class BalanceReconcileCommand extends ServiceReconcileCommand
{
    use ReconcilesBalanceRepositories;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reconcile:balance {service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform set reconciliation between vendor billing API and balance database';

    /**
     * Print the result to console and log the results to the app log.
     *
     * @return void
     */
    protected function postReconciliationTask(): void
    {
        if ($this->hasResults()) {
            if ($this->hasChanges()) {
                Log::info("$this->created Balances created, $this->deleted Balances deleted, $this->updated Balances updated");
                $this->info("$this->created Balances created, $this->deleted Balances deleted, $this->updated Balances updated");
            }
            if ($this->hasFailures()) {
                Log::error("Failed to create $this->createdFailed Balances, delete $this->deletedFailed Balances, update $this->updatedFailed Balances");
                $this->error("Failed to create $this->createdFailed Balances, delete $this->deletedFailed Balances, update $this->updatedFailed Balances");
            }
        } else {
            Log::info('No Balances created or deleted or updated');
            $this->info('No Balances created or deleted or updated');
        }
    }

    /**
     * Handler for successful balance creation.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleCreated(BaseModel $model): void
    {
        Log::info("Balance '{$model->getName()}' created");
        $this->info("Balance '{$model->getName()}' created");
    }

    /**
     * Handler for failed balance creation.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleFailedCreation(BaseModel $model): void
    {
        Log::error("Balance '{$model->getName()}' was not created");
        $this->error("Balance '{$model->getName()}' was not created");
    }

    /**
     * Handler for successful balance deletion.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleDeleted(BaseModel $model): void
    {
        Log::info("Balance '{$model->getName()}' deleted");
        $this->info("Balance '{$model->getName()}' deleted");
    }

    /**
     * Handler for failed balance deletion.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleFailedDeletion(BaseModel $model): void
    {
        Log::error("Balance '{$model->getName()}' was not deleted");
        $this->error("Balance '{$model->getName()}' was not deleted");
    }

    /**
     * Handler for successful balance update.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleUpdated(BaseModel $model): void
    {
        Log::info("Balance '{$model->getName()}' updated");
        $this->info("Balance '{$model->getName()}' updated");
    }

    /**
     * Handler for failed balance update.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleFailedUpdate(BaseModel $model): void
    {
        Log::error("Balance '{$model->getName()}' was not updated");
        $this->error("Balance '{$model->getName()}' was not updated");
    }

    /**
     * Handler for exception.
     *
     * @param  Exception  $exception
     * @return void
     */
    protected function handleException(Exception $exception): void
    {
        Log::error($exception->getMessage());
        $this->error($exception->getMessage());
    }

    /**
     * Get source repository for service.
     *
     * @param  Service  $service
     * @return Repository|null
     */
    protected function getSourceRepository(Service $service): ?Repository
    {
        return match ($service->value) {
            Service::DIGITALOCEAN => App::make(DigitalOceanSourceRepository::class),
            default => null,
        };
    }

    /**
     * Get destination repository for service.
     *
     * @param  Service  $service
     * @return Repository|null
     */
    protected function getDestinationRepository(Service $service): ?Repository
    {
        return match ($service->value) {
            Service::DIGITALOCEAN => App::make(DigitalOceanDestinationRepository::class),
            default => null,
        };
    }
}
