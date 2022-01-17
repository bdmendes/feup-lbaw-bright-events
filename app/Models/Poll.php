<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $table = 'polls';
    public $timestamps  = false;


    protected $dates = ['date'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
