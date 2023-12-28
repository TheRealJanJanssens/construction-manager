<?php

namespace App\Models;

use App\Traits\CreateUuid;
use App\Traits\HasAssets;
use App\Traits\HasReadables;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory, HasUuids, CreateUuid, HasAssets, HasReadables;

    protected $primaryKey = 'uuid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_uuid',
        'conversation_uuid',
        'content',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsReadByUser(User $user)
    {
        // Check if the user is not the sender
        if ($this->user_id !== $user->id) {
            // Check if the user has not already marked the message as read
            if (!$this->readByUser($user)) {
                ReadLog::create([
                    'user_uuid' => $user->id,
                    'message_uuid' => $this->id,
                    'read_at' => now(),
                ]);

                // Check if all users in the conversation have read the message
                $allUsersHaveRead = $this->conversation->users()
                    ->where('id', '!=', $this->user_id) // Exclude the sender
                    ->whereNotIn('id', $this->reads->pluck('user_uuid'))
                    ->doesntExist();

                if ($allUsersHaveRead) {
                    $this->update(['read_at' => now()]);
                }
            }
        }
    }
}
