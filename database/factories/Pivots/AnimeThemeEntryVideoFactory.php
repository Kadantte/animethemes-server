<?php

declare(strict_types=1);

namespace Database\Factories\Pivots;

use App\Pivots\AnimeThemeEntryVideo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AnimeThemeEntryVideoFactory.
 *
 * @method AnimeThemeEntryVideo createOne($attributes = [])
 * @method AnimeThemeEntryVideo makeOne($attributes = [])
 *
 * @extends Factory<AnimeThemeEntryVideo>
 */
class AnimeThemeEntryVideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<AnimeThemeEntryVideo>
     */
    protected $model = AnimeThemeEntryVideo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
