<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands\Document;

use App\Console\Commands\Document\DocumentDatabaseDumpCommand;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Class DocumentDatabaseDumpTest.
 */
class DocumentDatabaseDumpTest extends TestCase
{
    use WithFaker;

    /**
     * The Database Dump Command shall output "Database dump '{dumpFile}' has been created".
     *
     * @return void
     */
    public function testDataBaseDumpOutput(): void
    {
        Storage::fake('db-dumps');

        Date::setTestNow($this->faker->iso8601());

        $this->artisan(DocumentDatabaseDumpCommand::class)
            ->assertSuccessful()
            ->expectsOutputToContain('has been created');
    }

    /**
     * The Database Dump Command shall produce a file in the /path/to/project/storage/db-dumps directory.
     *
     * @return void
     */
    public function testDataBaseDumpFile(): void
    {
        Storage::fake('db-dumps');

        Date::setTestNow($this->faker->iso8601());

        $this->artisan(DocumentDatabaseDumpCommand::class)->run();

        static::assertCount(1, Storage::disk('db-dumps')->allFiles());
    }
}
