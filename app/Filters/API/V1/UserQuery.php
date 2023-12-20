<?php

namespace App\Filters\API\V1;

use App\Filters\API\ApiFilter;

class UserQuery extends ApiFilter{
    protected $allowedParams = [
        'role' => ['eq'],
        'status' => ['eq']
    ];
}
