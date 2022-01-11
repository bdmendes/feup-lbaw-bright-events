<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;
use App\Models\AttendanceRequest;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class Event extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'events';
    protected $dates = ['date'];

    protected $fillable = [
        'title',
        'description',
        'date',
        'event_state',
        'is_private',
        'organizer_id',
        'is_disabled',
        'tags',
        'cover_image_id'
    ];
    /**
     * The event organizer is
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * The cover image file is
     */
    public function image()
    {
        return $this->belongsTo(File::class, 'cover_image_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Comments of event
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'event');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'event_tags', 'event_id', 'tag_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'event_id');
    }

    public function attendees()
    {
        $attendees = [];
        
        foreach ($this->attendances as $attendance) {
            $attendees[] = User::find($attendance->attendee_id);
        }
        
        return $attendees;
    }

    public function stats()
    {
        $n_attendes = 0;
        $ages = [0, 0, 0, 0]; // 18-30, 30-45, 45-65, >65
        $genders = [0, 0, 0]; // Male, Female, Other
        foreach ($this->attendees() as $attendee) {
            $n_attendes++;
            $age = Carbon::parse($attendee->birth_date)->diffInYears(Carbon::now());
            if ($age >= 18 && $age < 30) {
                $ages[0]++;
            } elseif ($age >= 30 && $age < 45) {
                $ages[1]++;
            } elseif ($age >= 45 && $age < 65) {
                $ages[2]++;
            } elseif ($age >= 65) {
                $ages[3]++;
            }

            if ($attendee->gender == "Male") {
                $genders[0]++;
            } elseif ($attendee->gender == "Female") {
                $genders[1]++;
            } else {
                $genders[2]++;
            }
        }

        for ($i = 0; $i < count($ages); $i++) {
            $ages[$i] /= $n_attendes;
        }

        for ($i = 0; $i < count($genders); $i++) {
            $genders[$i] /= $n_attendes;
        }

        return [$ages, $genders];
    }

    public function invites()
    {
        return AttendanceRequest::where('event_id', $this->id)->get();
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $search_ = str_replace(" ", "|", implode(explode(" ", $search)));
            $query = $query->where(function ($query) use ($search_, $search) {
                $query->whereRaw('tsvectors @@ to_tsquery(\'english\', ?)', $search_)
                    ->orderByRaw('ts_rank(tsvectors, to_tsquery(\'english\', ?)) DESC', $search_)
                    ->orWhereRelation('organizer', 'username', 'ilike', '%' . $search . '%')
                    ->orWhereRelation('organizer', 'name', 'ilike', '%' . $search . '%')
                    ->orWhereHas('tags', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereRelation('location', 'name', 'ilike', '%' . $search . '%')
                    ->orWhereRelation('location', 'city', 'ilike', '%' . $search . '%')
                    ->orWhereRelation('location', 'country', 'ilike', '%' . $search . '%');
            });
        }
        return $query->where('is_private', 'false');
    }

    public function scopeOrganizer($query, $organizerId)
    {
        return $query->where('organizer_id', $id);
    }

    public function scopeTag($query, $tagName)
    {
        return $query->whereHas('tags', function ($query) use ($tagName) {
            $query->where('name', $tagName);
        });
    }
}
