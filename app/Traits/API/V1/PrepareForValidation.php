<?php

namespace App\Traits\API\V1;

use Illuminate\Support\Str;

trait PrepareForValidation{

    protected $defaultBulkRequest = false;

    /**
     * Handle an incoming request.
     * By converting camelCase into snake_case
     */

    public function prepareForValidation()
    {
        $data = [];
        $item = [];

        if($this->isBulkRequest()){
            foreach ($this->all() as $item){
                foreach ($item as $key => $value) {
                    $item[Str::snake($key)] = $value;
                }
                $data[] = $item;
            }
        }else{
            foreach ($this->all() as $key => $value) {
                $item[Str::snake($key)] = $value;
            }
            $data = $item;
        }

        $this->merge($data);
    }

    protected function isBulkRequest()
    {
        return $this->bulkRequest ?? $this->defaultBulkRequest;
    }
}
