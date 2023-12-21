<?php

namespace App\Filters\API\V1;

use App\Filters\API\ApiFilter;

//Example
class UnitQuery extends ApiFilter{
    protected $allowedParams = [
        // 'startDate' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        // 'dueDate' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        // 'completedDate' => ['eq', 'gt', 'lt', 'gte', 'lte']
    ];

    protected $columnMap = [
        // 'startDate' => 'start_date',
        // 'dueDate' => 'due_date',
        // 'completedDate' => 'completed_date'
    ];
}
