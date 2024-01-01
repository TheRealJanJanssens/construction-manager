<?php

namespace App\Filters\API\V1;

use App\Filters\API\ApiFilter;

class CommentQuery extends ApiFilter{
    protected $allowedParams = [
        'post_uuid' => ['eq'],
        'createdAt' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'updatedAt' => ['eq', 'gt', 'lt', 'gte', 'lte']
    ];

    protected $columnMap = [
        'postUuid' => 'post_uuid',
        'createdAt' => 'created_at',
        'updatedAt' => 'updated_at'
    ];
}