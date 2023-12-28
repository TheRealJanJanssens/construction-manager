<?php

namespace App\Filters\API\V1;

use App\Filters\API\ApiFilter;

class ConversationQuery extends ApiFilter{
    protected $allowedParams = [
        'createdAt' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'updatedAt' => ['eq', 'gt', 'lt', 'gte', 'lte']
    ];

    protected $columnMap = [
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];
}
