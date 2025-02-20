<?php

declare(strict_types=1);

namespace App\Nova\Actions\Wiki\Anime;

use App\Enums\Models\Wiki\ImageFacet;
use App\Enums\Models\Wiki\ResourceSite;
use App\Models\Auth\User;
use App\Models\Wiki\Anime;
use App\Models\Wiki\ExternalResource;
use App\Models\Wiki\Image;
use App\Pipes\BasePipe;
use App\Pipes\Wiki\Anime\Image\BackfillLargeCoverImage;
use App\Pipes\Wiki\Anime\Image\BackfillSmallCoverImage;
use App\Pipes\Wiki\Anime\Resource\BackfillAnidbResource;
use App\Pipes\Wiki\Anime\Resource\BackfillAnilistResource;
use App\Pipes\Wiki\Anime\Resource\BackfillAnnResource;
use App\Pipes\Wiki\Anime\Resource\BackfillKitsuResource;
use App\Pipes\Wiki\Anime\Resource\BackfillMalResource;
use App\Pipes\Wiki\Anime\Studio\BackfillAnimeStudios;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Http\Requests\NovaRequest;

/**
 * Class BackfillAnimeAction.
 */
class BackfillAnimeAction extends Action implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;

    final public const BACKFILL_ANIDB_RESOURCE = 'backfill_anidb_resource';
    final public const BACKFILL_ANILIST_RESOURCE = 'backfill_anilist_resource';
    final public const BACKFILL_ANN_RESOURCE = 'backfill_ann_resource';
    final public const BACKFILL_KITSU_RESOURCE = 'backfill_kitsu_resource';
    final public const BACKFILL_LARGE_COVER = 'backfill_large_cover';
    final public const BACKFILL_MAL_RESOURCE = 'backfill_mal_resource';
    final public const BACKFILL_SMALL_COVER = 'backfill_small_cover';
    final public const BACKFILL_STUDIOS = 'backfill_studios';

    /**
     * Create a new action instance.
     *
     * @param  User  $user
     */
    public function __construct(protected User $user)
    {
    }

    /**
     * Get the displayable name of the action.
     *
     * @return string
     *
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function name(): string
    {
        return __('nova.backfill_anime');
    }

    /**
     * Perform the action on the given models.
     *
     * @param  ActionFields  $fields
     * @param  Collection<int, Anime>  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models): mixed
    {
        foreach ($models as $anime) {
            if ($anime->resources()->doesntExist()) {
                $this->markAsFailed($anime, 'At least one Resource is required to backfill Anime');
                continue;
            }

            $pipes = $this->getPipes($fields, $anime);

            $pipeline = new Pipeline(Container::getInstance());

            try {
                $pipeline->send($this->user)
                    ->through($pipes)
                    ->then(fn () => $this->markAsFinished($anime));
            } catch (Exception $e) {
                $this->markAsFailed($anime, $e);
            } finally {
                // Try not to upset third-party APIs
                sleep(rand(3, 5));
            }
        }

        return $models;
    }

    /**
     * Get the fields available on the action.
     *
     * @param  NovaRequest  $request
     * @return array
     *
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function fields(NovaRequest $request): array
    {
        $anime = $request->resourceId !== null
            ? $request->findModel()
            : null;

        return [
            Heading::make(__('nova.backfill_resources')),

            Boolean::make(__('nova.backfill_kitsu_resource'), self::BACKFILL_KITSU_RESOURCE)
                ->help(__('nova.backfill_kitsu_resource_help'))
                ->default(fn () => $anime instanceof Anime && $anime->resources()->where(ExternalResource::ATTRIBUTE_SITE, ResourceSite::KITSU)->doesntExist()),

            Boolean::make(__('nova.backfill_anilist_resource'), self::BACKFILL_ANILIST_RESOURCE)
                ->help(__('nova.backfill_anilist_resource_help'))
                ->default(fn () => $anime instanceof Anime && $anime->resources()->where(ExternalResource::ATTRIBUTE_SITE, ResourceSite::ANILIST)->doesntExist()),

            Boolean::make(__('nova.backfill_mal_resource'), self::BACKFILL_MAL_RESOURCE)
                ->help(__('nova.backfill_mal_resource_help'))
                ->default(fn () => $anime instanceof Anime && $anime->resources()->where(ExternalResource::ATTRIBUTE_SITE, ResourceSite::MAL)->doesntExist()),

            Boolean::make(__('nova.backfill_anidb_resource'), self::BACKFILL_ANIDB_RESOURCE)
                ->help(__('nova.backfill_anidb_resource_help'))
                ->default(fn () => $anime instanceof Anime && $anime->resources()->where(ExternalResource::ATTRIBUTE_SITE, ResourceSite::ANIDB)->doesntExist()),

            Boolean::make(__('nova.backfill_ann_resource'), self::BACKFILL_ANN_RESOURCE)
                ->help(__('nova.backfill_ann_resource_help'))
                ->default(fn () => $anime instanceof Anime && $anime->resources()->where(ExternalResource::ATTRIBUTE_SITE, ResourceSite::ANN)->doesntExist()),

            Heading::make(__('nova.backfill_images')),

            Boolean::make(__('nova.backfill_large_cover'), self::BACKFILL_LARGE_COVER)
                ->help(__('nova.backfill_large_cover_help'))
                ->default(fn () => $anime instanceof Anime && $anime->images()->where(Image::ATTRIBUTE_FACET, ImageFacet::COVER_LARGE)->doesntExist()),

            Boolean::make(__('nova.backfill_small_cover'), self::BACKFILL_SMALL_COVER)
                ->help(__('nova.backfill_small_cover_help'))
                ->default(fn () => $anime instanceof Anime && $anime->images()->where(Image::ATTRIBUTE_FACET, ImageFacet::COVER_SMALL)->doesntExist()),

            Heading::make(__('nova.backfill_studios')),

            Boolean::make(__('nova.backfill_anime_studios'), self::BACKFILL_STUDIOS)
                ->help(__('nova.backfill_anime_studios_help'))
                ->default(fn () => $anime instanceof Anime && $anime->studios()->doesntExist()),
        ];
    }

    /**
     * Get the selected pipes for backfilling anime.
     *
     * @param  ActionFields  $fields
     * @param  Anime  $anime
     * @return BasePipe[]
     */
    protected function getPipes(ActionFields $fields, Anime $anime): array
    {
        $pipes = [];

        foreach ($this->getPipeMapping($anime) as $field => $pipe) {
            if (Arr::get($fields, $field) === true) {
                $pipes[] = $pipe;
            }
        }

        return $pipes;
    }

    /**
     * Get the mapping of anime pipes to their form fields.
     *
     * @param  Anime  $anime
     * @return array<string, BasePipe>
     */
    protected function getPipeMapping(Anime $anime): array
    {
        return [
            self::BACKFILL_KITSU_RESOURCE => new BackfillKitsuResource($anime),
            self::BACKFILL_ANILIST_RESOURCE => new BackfillAnilistResource($anime),
            self::BACKFILL_MAL_RESOURCE => new BackfillMalResource($anime),
            self::BACKFILL_ANIDB_RESOURCE => new BackfillAnidbResource($anime),
            self::BACKFILL_ANN_RESOURCE => new BackfillAnnResource($anime),
            self::BACKFILL_LARGE_COVER => new BackfillLargeCoverImage($anime),
            self::BACKFILL_SMALL_COVER => new BackfillSmallCoverImage($anime),
            self::BACKFILL_STUDIOS => new BackfillAnimeStudios($anime),
        ];
    }
}
