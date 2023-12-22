<?php

namespace App\Models;

use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory, HasUuids, CreateUuid;

    public $timestamps = false;
    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent',
        'name'
    ];

    public function parent()
    {
        return $this->hasOne('App\Models\Phase', 'parent');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Phase', 'parent');
    }
}
