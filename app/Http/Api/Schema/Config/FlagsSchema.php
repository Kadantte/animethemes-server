<?php

declare(strict_types=1);

namespace App\Http\Api\Schema\Config;

use App\Http\Api\Field\Config\Flags\FlagsAllowDiscordNotificationsField;
use App\Http\Api\Field\Config\Flags\FlagsAllowVideoStreamsField;
use App\Http\Api\Field\Config\Flags\FlagsAllowViewRecordingField;
use App\Http\Api\Field\Field;
use App\Http\Api\Include\AllowedInclude;
use App\Http\Api\Schema\Schema;
use App\Http\Resources\Config\Resource\FlagsResource;

/**
 * Class FlagsSchema.
 */
class FlagsSchema extends Schema
{
    /**
     * Get the type of the resource.
     *
     * @return string
     */
    public function type(): string
    {
        return FlagsResource::$wrap;
    }

    /**
     * Get the allowed includes.
     *
     * @return AllowedInclude[]
     */
    public function allowedIncludes(): array
    {
        return [];
    }

    /**
     * Get the direct fields of the resource.
     *
     * @return Field[]
     *
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function fields(): array
    {
        return [
            new FlagsAllowVideoStreamsField(),
            new FlagsAllowDiscordNotificationsField(),
            new FlagsAllowViewRecordingField(),
        ];
    }
}
