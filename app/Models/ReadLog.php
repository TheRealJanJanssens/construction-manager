<?php

namespace App\Models;

use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadLog extends Model
{
    use HasFactory, HasUuids, CreateUuid;

    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_uuid',
        'readable_uuid',
        'readable_type',
        'read_at'
    ];

    protected $dates = [
        'read_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function readable()
    {
        return $this->morphTo();
    }
}
