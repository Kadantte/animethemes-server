<?php

declare(strict_types=1);

namespace App\Scout\Elasticsearch\Api\Query;

use App\Models\Wiki\Video;
use App\Scout\Elasticsearch\Api\Schema\Schema;
use App\Scout\Elasticsearch\Api\Schema\Wiki\VideoSchema;
use ElasticScoutDriverPlus\Builders\MatchPhraseQueryBuilder;
use ElasticScoutDriverPlus\Builders\MatchQueryBuilder;
use ElasticScoutDriverPlus\Builders\NestedQueryBuilder;
use ElasticScoutDriverPlus\Builders\SearchRequestBuilder;
use ElasticScoutDriverPlus\Support\Query;

/**
 * Class VideoQueryPayload.
 */
class VideoQueryPayload extends ElasticQueryPayload
{
    /**
     * The model this payload is searching.
     *
     * @return string
     */
    public static function model(): string
    {
        return Video::class;
    }

    /**
     * The schema this payload is searching.
     *
     * @return Schema
     */
    public function schema(): Schema
    {
        return new VideoSchema();
    }

    /**
     * Build Elasticsearch query.
     *
     * @return SearchRequestBuilder
     */
    public function buildQuery(): SearchRequestBuilder
    {
        $query = Query::bool()
            ->should(
                (new MatchPhraseQueryBuilder())
                ->field('filename')
                ->query($this->criteria->getTerm())
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('filename')
                ->query($this->criteria->getTerm())
                ->operator('AND')
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('filename')
                ->query($this->criteria->getTerm())
                ->operator('AND')
                ->lenient(true)
                ->fuzziness('AUTO')
            )
            ->should(
                (new MatchPhraseQueryBuilder())
                ->field('tags')
                ->query($this->criteria->getTerm())
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('tags')
                ->query($this->criteria->getTerm())
                ->operator('AND')
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('tags')
                ->query($this->criteria->getTerm())
                ->operator('AND')
                ->lenient(true)
                ->fuzziness('AUTO')
            )
            ->should(
                (new MatchPhraseQueryBuilder())
                ->field('tags_slug')
                ->query($this->criteria->getTerm())
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('tags_slug')
                ->query($this->criteria->getTerm())
                ->operator('AND')
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('tags_slug')
                ->query($this->criteria->getTerm())
                ->operator('AND')
                ->lenient(true)
                ->fuzziness('AUTO')
            )
            ->should(
                (new MatchPhraseQueryBuilder())
                ->field('version_slug')
                ->query($this->criteria->getTerm())
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('version_slug')
                ->query($this->criteria->getTerm())
                ->operator('AND')
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('version_slug')
                ->query($this->criteria->getTerm())
                ->operator('AND')
                ->lenient(true)
                ->fuzziness('AUTO')
            )
            ->should(
                (new MatchPhraseQueryBuilder())
                ->field('anime_slug')
                ->query($this->criteria->getTerm())
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('anime_slug')
                ->query($this->criteria->getTerm())
                ->operator('AND')
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('anime_slug')
                ->query($this->criteria->getTerm())
                ->operator('AND')
                ->lenient(true)
                ->fuzziness('AUTO')
            )
            ->should(
                (new MatchPhraseQueryBuilder())
                ->field('synonym_slug')
                ->query($this->criteria->getTerm())
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('synonym_slug')
                ->query($this->criteria->getTerm())
                ->operator('AND')
            )
            ->should(
                (new MatchQueryBuilder())
                ->field('synonym_slug')
                ->query($this->criteria->getTerm())
                ->operator('AND')
                ->lenient(true)
                ->fuzziness('AUTO')
            )
            ->should(
                (new NestedQueryBuilder())
                ->path('entries')
                ->query(
                    (new NestedQueryBuilder())
                    ->path('entries.theme')
                    ->query(
                        (new NestedQueryBuilder())
                        ->path('entries.theme.anime')
                        ->query(
                            (new MatchPhraseQueryBuilder())
                            ->field('entries.theme.anime.name')
                            ->query($this->criteria->getTerm())
                        )
                    )
                )
            )
            ->should(
                (new NestedQueryBuilder())
                ->path('entries')
                ->query(
                    (new NestedQueryBuilder())
                    ->path('entries.theme')
                    ->query(
                        (new NestedQueryBuilder())
                        ->path('entries.theme.anime')
                        ->query(
                            (new MatchQueryBuilder())
                            ->field('entries.theme.anime.name')
                            ->query($this->criteria->getTerm())
                            ->operator('AND')
                        )
                    )
                )
            )
            ->should(
                (new NestedQueryBuilder())
                ->path('entries')
                ->query(
                    (new NestedQueryBuilder())
                    ->path('entries.theme')
                    ->query(
                        (new NestedQueryBuilder())
                        ->path('entries.theme.anime')
                        ->query(
                            (new MatchQueryBuilder())
                            ->field('entries.theme.anime.name')
                            ->query($this->criteria->getTerm())
                            ->operator('AND')
                            ->lenient(true)
                            ->fuzziness('AUTO')
                        )
                    )
                )
            )
            ->should(
                (new NestedQueryBuilder())
                ->path('entries')
                ->query(
                    (new NestedQueryBuilder())
                    ->path('entries.theme')
                    ->query(
                        (new NestedQueryBuilder())
                        ->path('entries.theme.anime')
                        ->query(
                            (new NestedQueryBuilder())
                            ->path('entries.theme.anime.synonyms')
                            ->query(
                                (new MatchPhraseQueryBuilder())
                                ->field('entries.theme.anime.synonyms.text')
                                ->query($this->criteria->getTerm())
                            )
                        )
                    )
                )
            )
            ->should(
                (new NestedQueryBuilder())
                ->path('entries')
                ->query(
                    (new NestedQueryBuilder())
                    ->path('entries.theme')
                    ->query(
                        (new NestedQueryBuilder())
                        ->path('entries.theme.anime')
                        ->query(
                            (new NestedQueryBuilder())
                            ->path('entries.theme.anime.synonyms')
                            ->query(
                                (new MatchQueryBuilder())
                                ->field('entries.theme.anime.synonyms.text')
                                ->query($this->criteria->getTerm())
                                ->operator('AND')
                            )
                        )
                    )
                )
            )
            ->should(
                (new NestedQueryBuilder())
                ->path('entries')
                ->query(
                    (new NestedQueryBuilder())
                    ->path('entries.theme')
                    ->query(
                        (new NestedQueryBuilder())
                        ->path('entries.theme.anime')
                        ->query(
                            (new NestedQueryBuilder())
                            ->path('entries.theme.anime.synonyms')
                            ->query(
                                (new MatchQueryBuilder())
                                ->field('entries.theme.anime.synonyms.text')
                                ->query($this->criteria->getTerm())
                                ->operator('AND')
                                ->lenient(true)
                                ->fuzziness('AUTO')
                            )
                        )
                    )
                )
            )
            ->should(
                (new NestedQueryBuilder())
                ->path('entries')
                ->query(
                    (new NestedQueryBuilder())
                    ->path('entries.theme')
                    ->query(
                        (new NestedQueryBuilder())
                        ->path('entries.theme.song')
                        ->query(
                            (new MatchPhraseQueryBuilder())
                            ->field('entries.theme.song.title')
                            ->query($this->criteria->getTerm())
                        )
                    )
                )
            )
            ->should(
                (new NestedQueryBuilder())
                ->path('entries')
                ->query(
                    (new NestedQueryBuilder())
                    ->path('entries.theme')
                    ->query(
                        (new NestedQueryBuilder())
                        ->path('entries.theme.song')
                        ->query(
                            (new MatchQueryBuilder())
                            ->field('entries.theme.song.title')
                            ->query($this->criteria->getTerm())
                            ->operator('AND')
                        )
                    )
                )
            )
            ->should(
                (new NestedQueryBuilder())
                ->path('entries')
                ->query(
                    (new NestedQueryBuilder())
                    ->path('entries.theme')
                    ->query(
                        (new NestedQueryBuilder())
                        ->path('entries.theme.song')
                        ->query(
                            (new MatchQueryBuilder())
                            ->field('entries.theme.song.title')
                            ->query($this->criteria->getTerm())
                            ->operator('AND')
                            ->lenient(true)
                            ->fuzziness('AUTO')
                        )
                    )
                )
            )
            ->minimumShouldMatch(1);

        return Video::searchQuery($query);
    }
}
