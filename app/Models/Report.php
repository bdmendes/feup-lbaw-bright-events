<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Report extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'reports';
    protected $dates = ['date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'report_motive', 'handled_by_id', 'reported_comment_id', 'reported_user_id', 'reported_event_id'
    ];

    public function reportedUser()
    {
        return $this->hasOne(User::class, 'id', 'reported_user_id');
    }

    public function reportedEvent()
    {
        return $this->hasOne(Event::class, 'id', 'reported_event_id');
    }

    public function reportedComment()
    {
        return $this->hasOne(Comment::class, 'id', 'reported_comment_id');
    }
}
