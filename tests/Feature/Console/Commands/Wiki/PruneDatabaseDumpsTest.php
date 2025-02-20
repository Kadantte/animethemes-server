<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands\Wiki;

use App\Console\Commands\PruneDatabaseDumpsCommand;
use App\Console\Commands\Wiki\WikiDatabaseDumpCommand;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class PruneDatabaseDumpsTest.
 */
class PruneDatabaseDumpsTest extends TestCase
{
    use WithFaker;

    /**
     * If no changes are needed, the Prune Database Dumps Command shall output 'No database dumps deleted'.
     *
     * @return void
     */
    public function testNoResults(): void
    {
        Storage::fake('db-dumps');

        $this->artisan(PruneDatabaseDumpsCommand::class, ['--hours' => 0])->expectsOutput('No database dumps deleted');
    }

    /**
     * If dumps are deleted, the Prune Database Dumps Command shall output '{Deleted Count} database dumps deleted'.
     *
     * @return void
     */
    public function testDeleted(): void
    {
        Storage::fake('db-dumps');

        $deletedCount = $this->faker->randomDigitNotNull();

        Collection::times($deletedCount, function () {
            Date::setTestNow($this->faker->iso8601());

            $this->artisan(WikiDatabaseDumpCommand::class)->run();
        });

        Date::setTestNow();

        $this->artisan(PruneDatabaseDumpsCommand::class, ['--hours' => -1])->expectsOutput("$deletedCount database dumps deleted");
    }
}
