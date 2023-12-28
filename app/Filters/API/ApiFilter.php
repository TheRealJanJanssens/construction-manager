<?php

namespace App\Filters\API;

use Illuminate\Http\Request;

class ApiFilter{
    protected $allowedParams = [];

    protected $columnMap = [];

    protected $operatorMap = [
        'eq' => '=',
        'neq' => '!=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];


    /**
     * Transforms the request into a acceptable array ot use in a eloquent where()
     *
     * @param Request $request
     *
     * @return array
     */
    public function transform(Request $request){
        $eloQuery = [];

        foreach($this->allowedParams as $param => $operators){
            $query = $request->query($param);

            if(!isset($query)){
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operator){
                if(isset($query[$operator])){
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}
