<?php

namespace App\Traits;

use App\Models\Asset;

trait HasAssets
{
    public function assets()
    {
        return $this->morphMany(Asset::class, 'assetable', id: 'assetable_uuid');
    }
}
