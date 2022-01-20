<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    public $timestamps  = false;

    protected $dates = ['date'];

    protected $fillable = [
        'is_seen'
    ];

    /**
     * Notification of event
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function attendanceRequest()
    {
        return $this->belongsTo(AttendanceRequest::class, 'attendance_request_id');
    }

    public function poll()
    {
        return $this->belongsTo(Poll::class, 'poll_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function addressee()
    {
        return $this->belongsTo(User::class, 'addressee_id');
    }
}
