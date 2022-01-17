<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PollOption;
use App\Models\Event;

class Poll extends Model
{
    use HasFactory;
    protected $dates = ['date'];
    protected $table = 'polls';
    public $timestamps  = false;
    protected $fillable = [
        'event_id',
        'creator_id',
        'title',
        'description',
        'is_open'
    ];

    public function options()
    {
        return $this->hasMany(PollOption::class, 'poll_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
