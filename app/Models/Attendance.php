<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'attendances';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'attendee_id',
    ];

    public function attendee()
    {
        $this->hasOne(User::class, 'id');
    }

    public function event()
    {
        $this->hasOne(Event::class, 'id');
    }
}
