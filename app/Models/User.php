<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'gender',
    ];

    protected $attributes = [
        'is_admin' => false,
        'is_blocked' => false,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The cards this user owns.
     */
    public function cards()
    {
        return $this->hasMany('App\Models\Card');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'attendee_id');
    }

    public function attended_events()
    {
        $attended_events = [];
        foreach ($this->attendances as $attendance) {
            $attended_events = Arr::add($attended_events, $attendance->event_id, Event::findOrFail($attendance->event_id));
        }
        return $attended_events;
    }

    public function profile_picture()
    {
        $this->belongsTo(File::class, 'profile_picture_id');
    }
}
