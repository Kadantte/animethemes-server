<?php

declare(strict_types=1);

namespace App\Models\Wiki\Anime;

use App\Enums\Models\Wiki\ThemeType;
use App\Events\Wiki\Anime\Theme\ThemeCreated;
use App\Events\Wiki\Anime\Theme\ThemeDeleted;
use App\Events\Wiki\Anime\Theme\ThemeDeleting;
use App\Events\Wiki\Anime\Theme\ThemeRestored;
use App\Events\Wiki\Anime\Theme\ThemeUpdated;
use App\Models\BaseModel;
use App\Models\Wiki\Anime;
use App\Models\Wiki\Anime\Theme\AnimeThemeEntry;
use App\Models\Wiki\Song;
use BenSampo\Enum\Enum;
use Database\Factories\Wiki\Anime\AnimeThemeFactory;
use ElasticScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Actionable;

/**
 * Class AnimeTheme.
 *
 * @property Anime $anime
 * @property int $anime_id
 * @property Collection<int, AnimeThemeEntry> $animethemeentries
 * @property string|null $group
 * @property int|null $sequence
 * @property string $slug
 * @property Song|null $song
 * @property int|null $song_id
 * @property int $theme_id
 * @property Enum|null $type
 *
 * @method static AnimeThemeFactory factory(...$parameters)
 */
class AnimeTheme extends BaseModel
{
    use Actionable;
    use Searchable;

    final public const TABLE = 'anime_themes';

    final public const ATTRIBUTE_ANIME = 'anime_id';
    final public const ATTRIBUTE_GROUP = 'group';
    final public const ATTRIBUTE_ID = 'theme_id';
    final public const ATTRIBUTE_SEQUENCE = 'sequence';
    final public const ATTRIBUTE_SLUG = 'slug';
    final public const ATTRIBUTE_SONG = 'song_id';
    final public const ATTRIBUTE_TYPE = 'type';

    final public const RELATION_ANIME = 'anime';
    final public const RELATION_ARTISTS = 'song.artists';
    final public const RELATION_ENTRIES = 'animethemeentries';
    final public const RELATION_IMAGES = 'anime.images';
    final public const RELATION_SONG = 'song';
    final public const RELATION_SYNONYMS = 'anime.animesynonyms';
    final public const RELATION_VIDEOS = 'animethemeentries.videos';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        AnimeTheme::ATTRIBUTE_ANIME,
        AnimeTheme::ATTRIBUTE_GROUP,
        AnimeTheme::ATTRIBUTE_SEQUENCE,
        AnimeTheme::ATTRIBUTE_SLUG,
        AnimeTheme::ATTRIBUTE_SONG,
        AnimeTheme::ATTRIBUTE_TYPE,
    ];

    /**
     * The event map for the model.
     *
     * Allows for object-based events for native Eloquent events.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ThemeCreated::class,
        'deleted' => ThemeDeleted::class,
        'deleting' => ThemeDeleting::class,
        'restored' => ThemeRestored::class,
        'updated' => ThemeUpdated::class,
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = AnimeTheme::TABLE;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = AnimeTheme::ATTRIBUTE_ID;

    /**
     * Modify the query used to retrieve models when making all of the models searchable.
     *
     * @param  Builder  $query
     * @return Builder
     */
    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with([
            AnimeTheme::RELATION_SYNONYMS,
            AnimeTheme::RELATION_SONG,
        ]);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();
        $array['anime'] = $this->anime->toSearchableArray();
        if ($this->song !== null) {
            $array['song'] = $this->song->toSearchableArray() + ['title_keyword' => $this->song->title];
        }

        return $array;
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        AnimeTheme::ATTRIBUTE_SEQUENCE => 'int',
        AnimeTheme::ATTRIBUTE_TYPE => ThemeType::class,
    ];

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->slug;
    }

    /**
     * Gets the anime that owns the theme.
     *
     * @return BelongsTo
     */
    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class, AnimeTheme::ATTRIBUTE_ANIME);
    }

    /**
     * Gets the song that the theme uses.
     *
     * @return BelongsTo
     */
    public function song(): BelongsTo
    {
        return $this->belongsTo(Song::class, AnimeTheme::ATTRIBUTE_SONG);
    }

    /**
     * Get the entries for the theme.
     *
     * @return HasMany
     */
    public function animethemeentries(): HasMany
    {
        return $this->hasMany(AnimeThemeEntry::class, AnimeThemeEntry::ATTRIBUTE_THEME);
    }
}
