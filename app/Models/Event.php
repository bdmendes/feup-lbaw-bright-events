<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attendance;
use App\Models\AttendanceRequest;
use Illuminate\Support\Arr;

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
        'cover_image_id'
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

    public function attendees()
    {
        $attendees = [];
        
        foreach ($this->attendances as $attendance) {
            $attendees[] = User::find($attendance->attendee_id);
        }
        
        return $attendees;
    }

    public function getInvites()
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
