<?php

declare(strict_types=1);

namespace App\Http\Api\Schema\Wiki;

use App\Http\Api\Field\Base\IdField;
use App\Http\Api\Field\Field;
use App\Http\Api\Field\Wiki\Artist\ArtistAsField;
use App\Http\Api\Field\Wiki\Artist\ArtistNameField;
use App\Http\Api\Field\Wiki\Artist\ArtistSlugField;
use App\Http\Api\Include\AllowedInclude;
use App\Http\Api\Schema\EloquentSchema;
use App\Http\Api\Schema\Wiki\Anime\Theme\EntrySchema;
use App\Http\Api\Schema\Wiki\Anime\ThemeSchema;
use App\Http\Resources\Wiki\Resource\ArtistResource;
use App\Models\Wiki\Artist;

/**
 * Class ArtistSchema.
 */
class ArtistSchema extends EloquentSchema
{
    /**
     * The model this schema represents.
     *
     * @return string
     */
    public function model(): string
    {
        return Artist::class;
    }

    /**
     * Get the type of the resource.
     *
     * @return string
     */
    public function type(): string
    {
        return ArtistResource::$wrap;
    }

    /**
     * Get the allowed includes.
     *
     * @return AllowedInclude[]
     */
    public function allowedIncludes(): array
    {
        return [
            new AllowedInclude(new AnimeSchema(), Artist::RELATION_ANIME),
            new AllowedInclude(new ArtistSchema(), Artist::RELATION_GROUPS),
            new AllowedInclude(new ArtistSchema(), Artist::RELATION_MEMBERS),
            new AllowedInclude(new ExternalResourceSchema(), Artist::RELATION_RESOURCES),
            new AllowedInclude(new ImageSchema(), Artist::RELATION_IMAGES),
            new AllowedInclude(new SongSchema(), Artist::RELATION_SONGS),
            new AllowedInclude(new ThemeSchema(), Artist::RELATION_ANIMETHEMES),

            // Undocumented paths needed for client builds
            new AllowedInclude(new ArtistSchema(), 'songs.artists'),
            new AllowedInclude(new SongSchema(), 'songs.animethemes.song'),
            new AllowedInclude(new ArtistSchema(), 'songs.animethemes.song.artists'),
            new AllowedInclude(new ImageSchema(), 'songs.animethemes.anime.images'),
            new AllowedInclude(new EntrySchema(), 'songs.animethemes.animethemeentries'),
            new AllowedInclude(new VideoSchema(), 'songs.animethemes.animethemeentries.videos'),
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
                new IdField(Artist::ATTRIBUTE_ID),
                new ArtistNameField(),
                new ArtistSlugField(),
                new ArtistAsField(),
            ],
        );
    }
}
