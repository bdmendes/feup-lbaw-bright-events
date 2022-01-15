<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps  = false;
    protected $table = 'comments';

    protected $fillable = [
        'commenter_id',
        'event_id',
        'body',
        'parent_id'
    ];

    public function author()
    {
        return $this->belongsTo('App\Models\User', 'commenter_id');
    }

    public function event()
    {
        return $this->belongsTo('App\Models\Event', 'event_id');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
