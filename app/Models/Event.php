<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;
use App\Models\Poll;
use App\Models\AttendanceRequest;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class Event extends Model
{
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
        'cover_image_id',
        'location_id'
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'cover_image_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'event_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'event_tags', 'event_id', 'tag_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'event_id');
    }

    public function attendanceRequests()
    {
        return $this->hasMany(AttendanceRequest::class, 'event_id');
    }

    public function attendees()
    {
        return $this->belongsToMany(User::class, 'attendances', 'event_id', 'attendee_id');
    }

    public function polls()
    {
        return $this->hasMany(Poll::class, 'event_id');
    }

    public function getGenderStats()
    {
        $genders = [0, 0, 0]; // Male, Female, Other
        foreach ($this->attendees as $attendee) {
            if ($attendee->gender == "Male") {
                $genders[0]++;
            } elseif ($attendee->gender == "Female") {
                $genders[1]++;
            } else {
                $genders[2]++;
            }
        }
        return $genders;
    }

    public function getAgeStats()
    {
        $ages = [0, 0, 0, 0]; // 18-30, 30-45, 45-65, >65
        foreach ($this->attendees as $attendee) {
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
        }
        return $ages;
    }

    public function getInvites()
    {
        return AttendanceRequest::where('event_id', $this->id)->where('is_invite', 'true')->where('is_handled', 'false')->get();
    }

    public function score()
    {
        $score = 0;
        $score += $this->loadCount("attendees")->attendees_count;
        $score += $this->loadCount("comments")->comments_count;
        foreach ($this->polls as $poll) {
            foreach ($poll->options as $option) {
                $score += $option->loadCount("voters")->voters_count;
            }
        }
        return $score;
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
