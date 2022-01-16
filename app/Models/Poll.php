<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PollOption;

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
        'description'
    ];

    public function options()
    {
        return $this->hasMany(PollOption::class, 'poll_id');
    }
}
