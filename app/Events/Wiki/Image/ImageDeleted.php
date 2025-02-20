<?php

declare(strict_types=1);

namespace App\Events\Wiki\Image;

use App\Events\Base\Wiki\WikiDeletedEvent;
use App\Models\Wiki\Image;
use App\Nova\Resources\Wiki\Image as ImageResource;

/**
 * Class ImageDeleted.
 *
 * @extends WikiDeletedEvent<Image>
 */
class ImageDeleted extends WikiDeletedEvent
{
    /**
     * Create a new event instance.
     *
     * @param  Image  $image
     */
    public function __construct(Image $image)
    {
        parent::__construct($image);
    }

    /**
     * Get the model that has fired this event.
     *
     * @return Image
     */
    public function getModel(): Image
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
        return "Image '**{$this->getModel()->getName()}**' has been deleted.";
    }

    /**
     * Get the message for the nova notification.
     *
     * @return string
     */
    protected function getNotificationMessage(): string
    {
        return "Image '{$this->getModel()->getName()}' has been deleted. It will be automatically pruned in one week. Please review.";
    }

    /**
     * Get the URL for the nova notification.
     *
     * @return string
     */
    protected function getNotificationUrl(): string
    {
        $uriKey = ImageResource::uriKey();

        return "/resources/$uriKey/{$this->getModel()->getKey()}";
    }
}
