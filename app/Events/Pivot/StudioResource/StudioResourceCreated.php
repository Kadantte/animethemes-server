<?php

declare(strict_types=1);

namespace App\Events\Pivot\StudioResource;

use App\Events\Base\Pivot\PivotCreatedEvent;
use App\Models\Wiki\ExternalResource;
use App\Models\Wiki\Studio;
use App\Pivots\StudioResource;

/**
 * Class StudioResourceCreated.
 *
 * @extends PivotCreatedEvent<Studio, ExternalResource>
 */
class StudioResourceCreated extends PivotCreatedEvent
{
    /**
     * Create a new event instance.
     *
     * @param  StudioResource  $studioResource
     */
    public function __construct(StudioResource $studioResource)
    {
        parent::__construct($studioResource->studio, $studioResource->resource);
    }

    /**
     * Get the description for the Discord message payload.
     *
     * @return string
     */
    protected function getDiscordMessageDescription(): string
    {
        $foreign = $this->getForeign();
        $related = $this->getRelated();

        return "Resource '**{$foreign->getName()}**' has been attached to Studio '**{$related->getName()}**'.";
    }
}
