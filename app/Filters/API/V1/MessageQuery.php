<?php

namespace App\Filters\API\V1;

use App\Filters\API\ApiFilter;

class MessageQuery extends ApiFilter{
    protected $allowedParams = [
        'conversation_uuid' => ['eq'],
        'createdAt' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'updatedAt' => ['eq', 'gt', 'lt', 'gte', 'lte']
    ];

    protected $columnMap = [
        'conversationUuid' => 'conversation_uuid',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];
}
