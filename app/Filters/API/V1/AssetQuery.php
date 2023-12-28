<?php

namespace App\Filters\API\V1;

use App\Filters\API\ApiFilter;

class AssetQuery extends ApiFilter{
    protected $allowedParams = [
        'type' => ['eq','neq'],
        'createdAt' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'updatedAt' => ['eq', 'gt', 'lt', 'gte', 'lte']
    ];

    protected $columnMap = [
        'type' => 'type',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];
}
