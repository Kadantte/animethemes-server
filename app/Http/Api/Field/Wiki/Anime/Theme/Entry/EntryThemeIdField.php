<?php

declare(strict_types=1);

namespace App\Http\Api\Field\Wiki\Anime\Theme\Entry;

use App\Contracts\Http\Api\Field\CreatableField;
use App\Contracts\Http\Api\Field\SelectableField;
use App\Contracts\Http\Api\Field\UpdatableField;
use App\Http\Api\Criteria\Field\Criteria;
use App\Http\Api\Field\Field;
use App\Models\Wiki\Anime\AnimeTheme;
use App\Models\Wiki\Anime\Theme\AnimeThemeEntry;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class EntryThemeIdField.
 */
class EntryThemeIdField extends Field implements CreatableField, SelectableField, UpdatableField
{
    /**
     * Create a new field instance.
     */
    public function __construct()
    {
        parent::__construct(AnimeThemeEntry::ATTRIBUTE_THEME);
    }

    /**
     * Set the creation validation rules for the field.
     *
     * @param  Request  $request
     * @return array
     */
    public function getCreationRules(Request $request): array
    {
        return [
            'required',
            'integer',
            Rule::exists(AnimeTheme::TABLE, AnimeTheme::ATTRIBUTE_ID),
        ];
    }

    /**
     * Determine if the field should be included in the select clause of our query.
     *
     * @param  Criteria|null  $criteria
     * @return bool
     */
    public function shouldSelect(?Criteria $criteria): bool
    {
        // Needed to match theme relation.
        return true;
    }

    /**
     * Set the update validation rules for the field.
     *
     * @param  Request  $request
     * @return array
     */
    public function getUpdateRules(Request $request): array
    {
        return [
            'sometimes',
            'required',
            'integer',
            Rule::exists(AnimeTheme::TABLE, AnimeTheme::ATTRIBUTE_ID),
        ];
    }
}
