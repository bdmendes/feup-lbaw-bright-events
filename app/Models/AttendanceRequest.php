<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRequest extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'attendance_requests';

    protected $fillable = [
        'event_id', 'attendee_id', 'is_invite'
    ];

    public function attendee()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }
}
