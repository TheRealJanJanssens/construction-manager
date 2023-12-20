<?php

namespace App\Filters\API\V1;

use App\Filters\API\ApiFilter;

//Example
class ProjectQuery extends ApiFilter{
    protected $allowedParams = [
        'startDate' => ['eq', 'gt', 'lt', 'gte', 'lte'],
        'endDate' => ['eq', 'gt', 'lt', 'gte', 'lte']
    ];

    protected $columnMap = [
        'startDate' => 'start_date',
        'endDate' => 'end_date'
    ];
}
