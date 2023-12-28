<?php

namespace App\Traits;

use App\Models\Asset;
use App\Models\User;

trait HasReadables
{
    public function reads()
    {
        return $this->morphMany(Asset::class, 'readable', id: 'readable_uuid');
    }

    public function isRead()
    {
        //TODO: rewrite this function as it is not working or accurate in this way
        return $this->read_at !== null;
    }

    public function readByUser(User $user)
    {
        return $this->reads()->where('user_uuid', $user->id)->exists();
    }
}
