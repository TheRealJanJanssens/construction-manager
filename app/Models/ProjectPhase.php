<?php

namespace App\Models;

use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPhase extends Model
{
    use HasFactory, HasUuids, CreateUuid;

    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phase_uuid',
        'project_uuid',
        'start_date',
        'due_date',
        'completed_date',
    ];

    public function phase()
    {
        return $this->hasOne(Phase::class, 'uuid', 'phase_uuid');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
