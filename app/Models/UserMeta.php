<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserMeta extends Model
{
    use HasFactory, HasUuids, CreateUuid;

    protected $primaryKey = 'uuid';

    protected $fillable = [
        'user_uuid',
        'job_title'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
