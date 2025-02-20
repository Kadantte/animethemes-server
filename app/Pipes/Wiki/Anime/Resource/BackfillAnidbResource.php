<?php

declare(strict_types=1);

namespace App\Pipes\Wiki\Anime\Resource;

use App\Enums\Models\Wiki\ResourceSite;
use App\Models\Wiki\ExternalResource;
use App\Pipes\Wiki\Anime\BackfillAnimeResource;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

/**
 * Class BackfillAnidbResource.
 */
class BackfillAnidbResource extends BackfillAnimeResource
{
    /**
     * Get the site to backfill.
     *
     * @return ResourceSite
     */
    protected function getSite(): ResourceSite
    {
        return ResourceSite::ANIDB();
    }

    /**
     * Query third-party APIs to find Resource mapping.
     *
     * @return ExternalResource|null
     *
     * @throws RequestException
     */
    protected function getResource(): ?ExternalResource
    {
        // Allow fall-throughs in case AniDB Resource is not mapped to every external site.

        $malResource = $this->getModel()->resources()->firstWhere(ExternalResource::ATTRIBUTE_SITE, ResourceSite::MAL);
        if ($malResource instanceof ExternalResource) {
            $anidbResource = $this->getAnidbMapping($malResource, 'myanimelist');
            if ($anidbResource !== null) {
                return $anidbResource;
            }

            // failed mapping, sleep before re-attempting
            sleep(rand(1, 3));
        }

        $anilistResource = $this->getModel()->resources()->firstWhere(ExternalResource::ATTRIBUTE_SITE, ResourceSite::ANILIST);
        if ($anilistResource instanceof ExternalResource) {
            $anidbResource = $this->getAnidbMapping($anilistResource, 'anilist');
            if ($anidbResource !== null) {
                return $anidbResource;
            }

            // failed mapping, sleep before re-attempting
            sleep(rand(1, 3));
        }

        $kitsuResource = $this->getModel()->resources()->firstWhere(ExternalResource::ATTRIBUTE_SITE, ResourceSite::KITSU);
        if ($kitsuResource instanceof ExternalResource) {
            return $this->getAnidbMapping($kitsuResource, 'kitsu');
        }

        return null;
    }

    /**
     * Query Yuna API for AniDB mapping.
     *
     * @param  ExternalResource  $resource
     * @param  string  $source
     * @return ExternalResource|null
     *
     * @throws RequestException
     */
    protected function getAnidbMapping(ExternalResource $resource, string $source): ?ExternalResource
    {
        $response = Http::get('https://relations.yuna.moe/api/ids', [
            'source' => $source,
            'id' => $resource->external_id,
        ])
            ->throw()
            ->json();

        $anidbId = Arr::get($response, 'anidb');

        // Only proceed if we have a match
        if ($anidbId !== null) {
            return $this->getOrCreateResource($anidbId);
        }

        return null;
    }
}
