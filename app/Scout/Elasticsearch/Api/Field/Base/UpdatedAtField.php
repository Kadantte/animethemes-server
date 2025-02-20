<?php

declare(strict_types=1);

namespace App\Scout\Elasticsearch\Api\Field\Base;

use App\Models\BaseModel;
use App\Scout\Elasticsearch\Api\Field\DateField;

/**
 * Class UpdatedAtField.
 */
class UpdatedAtField extends DateField
{
    /**
     * Create a new field instance.
     */
    public function __construct()
    {
        parent::__construct(BaseModel::ATTRIBUTE_UPDATED_AT);
    }
}
