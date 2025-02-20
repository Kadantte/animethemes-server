<?php

declare(strict_types=1);

namespace App\Listeners\Wiki\Video;

use App\Enums\Models\Wiki\VideoSource;
use App\Events\Wiki\Video\VideoCreating;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Class InitializeVideoTags.
 */
class InitializeVideoTags
{
    /**
     * Handle the event.
     *
     * @param  VideoCreating  $event
     * @return void
     */
    public function handle(VideoCreating $event): void
    {
        $video = $event->getModel();

        try {
            // Match Tags of filename
            // Format: "{Base Name}-{OP|ED}{Sequence}v{Version}-{Tags}"
            preg_match('/^.*-(?:OP|ED).*-(.*)$/', $video->filename, $tagsMatch);

            // Check if the filename has tags, which is not guaranteed
            if (! empty($tagsMatch)) {
                $tags = $tagsMatch[1];

                // Set true/false if tag is included/excluded
                $video->nc = Str::contains($tags, 'NC');
                $video->subbed = Str::contains($tags, 'Subbed');
                $video->lyrics = Str::contains($tags, 'Lyrics');
                // Note: Our naming convention does not include "Uncen"

                // Set resolution to numeric tag if included
                preg_match('/\d+/', $tags, $resolution);
                if (! empty($resolution)) {
                    $video->resolution = intval($resolution[0]);
                }

                // Special cases for implicit resolution
                if (in_array($tags, ['NCBD', 'NCBDLyrics'])) {
                    $video->resolution = 720;
                }

                // Set source type for first matching tag to key
                foreach (VideoSource::getKeys() as $sourceKey) {
                    if (Str::contains($tags, $sourceKey)) {
                        $video->source = VideoSource::getValue($sourceKey);
                        break;
                    }
                }

                // Note: Our naming convention does not include Overlap type
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
