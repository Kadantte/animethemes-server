<?php

declare(strict_types=1);

namespace App\Http\Resources\Config\Resource;

use App\Constants\Config\FlagConstants;
use App\Http\Api\Query\ReadQuery;
use App\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\MissingValue;

/**
 * Class FlagsResource.
 */
class FlagsResource extends BaseResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'flags';

    /**
     * Create a new resource instance.
     *
     * @param  ReadQuery  $query
     * @return void
     */
    public function __construct(ReadQuery $query)
    {
        parent::__construct(new MissingValue(), $query);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     *
     * @noinspection PhpMissingParentCallCommonInspection
     */
    public function toArray($request): array
    {
        $result = [];

        if ($this->isAllowedField(FlagConstants::ALLOW_VIDEO_STREAMS_FLAG)) {
            $result[FlagConstants::ALLOW_VIDEO_STREAMS_FLAG] = config(FlagConstants::ALLOW_VIDEO_STREAMS_FLAG_QUALIFIED, false);
        }

        if ($this->isAllowedField(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG)) {
            $result[FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG] = config(FlagConstants::ALLOW_DISCORD_NOTIFICATIONS_FLAG_QUALIFIED, false);
        }

        if ($this->isAllowedField(FlagConstants::ALLOW_VIEW_RECORDING_FLAG)) {
            $result[FlagConstants::ALLOW_VIEW_RECORDING_FLAG] = config(FlagConstants::ALLOW_VIEW_RECORDING_FLAG_QUALIFIED, false);
        }

        return $result;
    }
}
