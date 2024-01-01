<?php

namespace App\Filters\API\V1;

use App\Filters\API\ApiFilter;

class PostQuery extends ApiFilter{
    protected $allowedParams = [
        'project_uuid' => ['eq'],
        'createdAt' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'updatedAt' => ['eq', 'gt', 'lt', 'gte', 'lte']
    ];

    protected $columnMap = [
        'projectUuid' => 'project_uuid',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];
}
