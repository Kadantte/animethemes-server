<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Concerns\Repositories\Wiki\ReconcilesVideoRepositories;
use App\Models\BaseModel;
use App\Repositories\Eloquent\Wiki\VideoRepository as VideoDestinationRepository;
use App\Repositories\Service\DigitalOcean\VideoRepository as VideoSourceRepository;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

/**
 * Class VideoSeeder.
 */
class VideoSeeder extends Seeder
{
    use ReconcilesVideoRepositories;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $sourceRepository = App::make(VideoSourceRepository::class);

        $destinationRepository = App::make(VideoDestinationRepository::class);

        $this->reconcileRepositories($sourceRepository, $destinationRepository);
    }

    /**
     * Print the result to console and log the results to the app log.
     *
     * @return void
     */
    protected function postReconciliationTask(): void
    {
        if ($this->hasResults()) {
            if ($this->hasChanges()) {
                Log::info("$this->created Videos created, $this->deleted Videos deleted, $this->updated Videos updated");
            }
            if ($this->hasFailures()) {
                Log::error("Failed to create $this->createdFailed Videos, delete $this->deletedFailed Videos, update $this->updatedFailed Videos");
            }
        } else {
            Log::info('No Videos created or deleted or updated');
        }
    }

    /**
     * Handler for successful video creation.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleCreated(BaseModel $model): void
    {
        Log::info("Video '{$model->getName()}' created");
    }

    /**
     * Handler for failed video creation.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleFailedCreation(BaseModel $model): void
    {
        Log::error("Video '{$model->getName()}' was not created");
    }

    /**
     * Handler for successful video deletion.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleDeleted(BaseModel $model): void
    {
        Log::info("Video '{$model->getName()}' deleted");
    }

    /**
     * Handler for failed video deletion.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleFailedDeletion(BaseModel $model): void
    {
        Log::error("Video '{$model->getName()}' was not deleted");
    }

    /**
     * Handler for successful video update.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleUpdated(BaseModel $model): void
    {
        Log::info("Video '{$model->getName()}' updated");
    }

    /**
     * Handler for failed video update.
     *
     * @param  BaseModel  $model
     * @return void
     */
    protected function handleFailedUpdate(BaseModel $model): void
    {
        Log::error("Video '{$model->getName()}' was not updated");
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
    }
}
