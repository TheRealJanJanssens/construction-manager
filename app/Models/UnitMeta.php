<?php

namespace App\Models;

use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitMeta extends Model
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
        'type',
        'address',
        'city',
        'postal_code',
        'start_date',
        'due_date',
        'completed_date',
        'extra'
    ];

    public function unit(){
        return $this->belongsTo(Unit::class);
    }
}
