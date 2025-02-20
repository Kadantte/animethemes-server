<?php

declare(strict_types=1);

namespace App\Rules\Api;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

/**
 * Class DistinctIgnoringDirectionRule.
 */
class DistinctIgnoringDirectionRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $values = Str::of($value)->explode(',');

        $duplicateValues = $values->duplicates(function (mixed $sort) {
            if (is_string($sort) && Str::startsWith($sort, '-')) {
                return Str::replaceFirst('-', '', $sort);
            }

            return $sort;
        });

        return $duplicateValues->isEmpty();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('validation.distinct');
    }
}
