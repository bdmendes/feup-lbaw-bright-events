<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // Don't add create and update timestamps in database.
    public $timestamps  = false;
    protected $table = 'event';

    protected $fillable = [
        'title',
        'description',
        'date'
    ];
    /**
     * The event organizer is
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer');
    }

    /**
     * The cover image file is
     */
    public function image()
    {
        return $this->belongsTo(File::class, 'cover_image');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location');
    }

    /**
     * Comments of event
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
