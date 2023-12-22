<?php

namespace App\Models;

use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, HasUuids, CreateUuid;

    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unit_uuid',
        'name',
        'start_date',
        'due_date',
        'completed_date',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function phases()
    {
        return $this->hasMany(ProjectPhase::class);
    }
}
