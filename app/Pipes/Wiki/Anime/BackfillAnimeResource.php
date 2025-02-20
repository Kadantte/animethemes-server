<?php

declare(strict_types=1);

namespace App\Pipes\Wiki\Anime;

use App\Enums\Models\Wiki\ResourceSite;
use App\Models\Wiki\Anime;
use App\Models\Wiki\ExternalResource;
use App\Nova\Resources\BaseResource;
use App\Nova\Resources\Wiki\Anime as AnimeNovaResource;
use App\Pipes\Wiki\BackfillResource;
use App\Pivots\AnimeResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;

/**
 * Class BackfillAnimeResource.
 *
 * @extends BackfillResource<Anime>
 */
abstract class BackfillAnimeResource extends BackfillResource
{
    /**
     * Create a new pipe instance.
     *
     * @param  Anime  $anime
     */
    public function __construct(Anime $anime)
    {
        parent::__construct($anime);
    }

    /**
     * Get the model passed into the pipeline.
     *
     * @return Anime
     */
    public function getModel(): Anime
    {
        return $this->model;
    }

    /**
     * Get the relation to images.
     *
     * @return BelongsToMany
     */
    protected function relation(): BelongsToMany
    {
        return $this->getModel()->resources();
    }

    /**
     * Get the nova resource.
     *
     * @return class-string<BaseResource>
     */
    protected function resource(): string
    {
        return AnimeNovaResource::class;
    }

    /**
     * Get or Create Resource from response.
     *
     * @param  int  $id
     * @param  string|null  $slug
     * @return ExternalResource
     */
    protected function getOrCreateResource(int $id, string $slug = null): ExternalResource
    {
        $resource = ExternalResource::query()
            ->where(ExternalResource::ATTRIBUTE_SITE, $this->getSite()->value)
            ->where(ExternalResource::ATTRIBUTE_EXTERNAL_ID, $id)
            ->whereHas(ExternalResource::RELATION_ANIME, fn (Builder $animeQuery) => $animeQuery->whereKey($this->getModel()))
            ->first();

        if ($resource === null) {
            Log::info("Creating {$this->getSite()->description} Resource '$id'");

            $resource = ExternalResource::query()->create([
                ExternalResource::ATTRIBUTE_EXTERNAL_ID => $id,
                ExternalResource::ATTRIBUTE_LINK => ResourceSite::formatAnimeResourceLink($this->getSite(), $id, $slug),
                ExternalResource::ATTRIBUTE_SITE => $this->getSite()->value,
            ]);
        }

        return $resource;
    }

    /**
     * Attach Resource to Anime.
     *
     * @param  ExternalResource  $resource
     * @return void
     */
    protected function attachResource(ExternalResource $resource): void
    {
        if (AnimeResource::query()
            ->where($this->getModel()->getKeyName(), $this->getModel()->getKey())
            ->where($resource->getKeyName(), $resource->getKey())
            ->doesntExist()
        ) {
            Log::info("Attaching Resource '{$resource->getName()}' to {$this->label()} '{$this->getModel()->getName()}'");
            $this->relation()->attach($resource);
        }
    }
}
