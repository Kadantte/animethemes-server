<?php

declare(strict_types=1);

namespace App\Scout\Elasticsearch\Api\Schema\Wiki;

use App\Http\Api\Include\AllowedInclude;
use App\Http\Api\Schema\Wiki\ExternalResourceSchema;
use App\Http\Api\Schema\Wiki\ImageSchema;
use App\Http\Resources\Wiki\Resource\StudioResource;
use App\Models\Wiki\Studio;
use App\Scout\Elasticsearch\Api\Field\Base\IdField;
use App\Scout\Elasticsearch\Api\Field\Field;
use App\Scout\Elasticsearch\Api\Field\Wiki\Studio\StudioNameField;
use App\Scout\Elasticsearch\Api\Field\Wiki\Studio\StudioSlugField;
use App\Scout\Elasticsearch\Api\Schema\Schema;

/**
 * Class StudioSchema.
 */
class StudioSchema extends Schema
{
    /**
     * The model this schema represents.
     *
     * @return string
     */
    public function model(): string
    {
        return Studio::class;
    }

    /**
     * Get the type of the resource.
     *
     * @return string
     */
    public function type(): string
    {
        return StudioResource::$wrap;
    }

    /**
     * Get the allowed includes.
     *
     * @return AllowedInclude[]
     */
    public function allowedIncludes(): array
    {
        return [
            new AllowedInclude(new AnimeSchema(), Studio::RELATION_ANIME),
            new AllowedInclude(new ExternalResourceSchema(), Studio::RELATION_RESOURCES),
            new AllowedInclude(new ImageSchema(), Studio::RELATION_IMAGES),
        ];
    }

    /**
     * Get the direct fields of the resource.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return array_merge(
            parent::fields(),
            [
                new IdField(Studio::ATTRIBUTE_ID),
                new StudioNameField(),
                new StudioSlugField(),
            ],
        );
    }
}
