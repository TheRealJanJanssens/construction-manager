<?php

namespace App\Models;

use App\Traits\CreateUuid;
use App\Traits\HasAssets;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
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
        'group_uuid'
        //status
        //eerst komende geplande werken
    ];

    public function meta()
    {
        return $this->hasOne(UnitMeta::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
