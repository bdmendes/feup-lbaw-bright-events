<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Event;

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
            $event = Event::findOrFail($attendance->event_id);
            if (!$event->is_disabled) {
                $attended_events = Arr::add($attended_events, $attendance->event_id, $event);
            }
        }
        return $attended_events;
    }

    public function profile_picture()
    {
        return $this->belongsTo(File::class, 'profile_picture_id');
    }

    public function attends($event_id)
    {
        foreach ($this->attendances as $attendance) {
            if ($attendance->event_id == $event_id && $attendance->attendee_id == $this->id) {
                return true;
            }
        }

        return false;
    }

    public function score()
    {
        $score = 0;
        foreach ($this->events as $event) {
            $score += $event->score();
        }

        return $score;
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $search_ = str_replace(" ", "|", implode(explode(" ", $search)));
            $query = $query->where(function ($query) use ($search, $search_) {
                $query = $query->whereRaw('tsvectors @@ to_tsquery(\'english\', ?)', $search_)
                    ->orderByRaw('ts_rank(tsvectors, to_tsquery(\'english\', ?)) DESC', $search_)
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('name', 'ilike', '%' . $search . '%');
            });
        }
        return $query->where('is_admin', 'false');
    }
}
