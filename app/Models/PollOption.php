<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PollOption extends Model
{
    use HasFactory;
    protected $table = 'poll_options';
    public $timestamps  = false;
    protected $fillable = [
        'name',
        'poll_id'
    ];

    public function voters()
    {
        return $this->belongsToMany(User::class, 'user_poll_options', 'poll_option_id', 'voter_id');
    }

    public function hasBeenSelectedBy($userId)
    {
        foreach ($this->voters as $voter) {
            if ($voter->id == $userId) {
                return true;
            }
        }
        return false;
    }
}
