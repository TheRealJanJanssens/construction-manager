<?php

namespace App\Models;

use App\Traits\CreateUuid;
use App\Traits\HasAssets;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitGroup extends Model
{
    use HasFactory, HasUuids, CreateUuid, HasAssets;

    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    public function group(){
        return $this->belongsTo(UnitGroup::class);
    }
}
