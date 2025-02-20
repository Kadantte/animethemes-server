<?php

declare(strict_types=1);

namespace Tests\Feature\Events\Document;

use App\Events\Document\Page\PageCreated;
use App\Events\Document\Page\PageDeleted;
use App\Events\Document\Page\PageRestored;
use App\Events\Document\Page\PageUpdated;
use App\Models\Document\Page;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class PageTest.
 */
class PageTest extends TestCase
{
    /**
     * When a Page is created, an PageCreated event shall be dispatched.
     *
     * @return void
     */
    public function testPageCreatedEventDispatched(): void
    {
        Event::fake();

        Page::factory()->createOne();

        Event::assertDispatched(PageCreated::class);
    }

    /**
     * When a Page is deleted, an PageDeleted event shall be dispatched.
     *
     * @return void
     */
    public function testPageDeletedEventDispatched(): void
    {
        Event::fake();

        $page = Page::factory()->createOne();

        $page->delete();

        Event::assertDispatched(PageDeleted::class);
    }

    /**
     * When a Page is restored, an PageRestored event shall be dispatched.
     *
     * @return void
     */
    public function testPageRestoredEventDispatched(): void
    {
        Event::fake();

        $page = Page::factory()->createOne();

        $page->restore();

        Event::assertDispatched(PageRestored::class);
    }

    /**
     * When a Page is restored, a PageUpdated event shall not be dispatched.
     * Note: This is a customization that overrides default framework behavior.
     * An updated event is fired on restore.
     *
     * @return void
     */
    public function testPageRestoresQuietly(): void
    {
        Event::fake();

        $page = Page::factory()->createOne();

        $page->restore();

        Event::assertNotDispatched(PageUpdated::class);
    }

    /**
     * When a Page is updated, an PageUpdated event shall be dispatched.
     *
     * @return void
     */
    public function testPageUpdatedEventDispatched(): void
    {
        Event::fake();

        $page = Page::factory()->createOne();
        $changes = Page::factory()->makeOne();

        $page->fill($changes->getAttributes());
        $page->save();

        Event::assertDispatched(PageUpdated::class);
    }
}
