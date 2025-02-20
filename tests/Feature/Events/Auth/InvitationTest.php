<?php

declare(strict_types=1);

namespace Tests\Feature\Events\Auth;

use App\Events\Auth\Invitation\InvitationCreated;
use App\Events\Auth\Invitation\InvitationDeleted;
use App\Events\Auth\Invitation\InvitationRestored;
use App\Events\Auth\Invitation\InvitationUpdated;
use App\Models\Auth\Invitation;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class InvitationTest.
 */
class InvitationTest extends TestCase
{
    /**
     * When an Invitation is created, an InvitationCreated event shall be dispatched.
     *
     * @return void
     */
    public function testInvitationCreatedEventDispatched(): void
    {
        Event::fake(InvitationCreated::class);

        Invitation::factory()->createOne();

        Event::assertDispatched(InvitationCreated::class);
    }

    /**
     * When an Invitation is deleted, an InvitationDeleted event shall be dispatched.
     *
     * @return void
     */
    public function testInvitationDeletedEventDispatched(): void
    {
        Event::fake(InvitationDeleted::class);

        $invitation = Invitation::factory()->createOne();

        $invitation->delete();

        Event::assertDispatched(InvitationDeleted::class);
    }

    /**
     * When an Invitation is restored, an InvitationRestored event shall be dispatched.
     *
     * @return void
     */
    public function testInvitationRestoredEventDispatched(): void
    {
        Event::fake(InvitationRestored::class);

        $invitation = Invitation::factory()->createOne();

        $invitation->restore();

        Event::assertDispatched(InvitationRestored::class);
    }

    /**
     * When an Invitation is restored, an InvitationUpdated event shall not be dispatched.
     * Note: This is a customization that overrides default framework behavior.
     * An updated event is fired on restore.
     *
     * @return void
     */
    public function testInvitationRestoresQuietly(): void
    {
        Event::fake();

        $invitation = Invitation::factory()->createOne();

        $invitation->restore();

        Event::assertNotDispatched(InvitationUpdated::class);
    }

    /**
     * When an Invitation is updated, an InvitationUpdated event shall be dispatched.
     *
     * @return void
     */
    public function testInvitationUpdatedEventDispatched(): void
    {
        Event::fake(InvitationUpdated::class);

        $invitation = Invitation::factory()->createOne();
        $changes = Invitation::factory()->makeOne();

        $invitation->fill($changes->getAttributes());
        $invitation->save();

        Event::assertDispatched(InvitationUpdated::class);
    }
}
