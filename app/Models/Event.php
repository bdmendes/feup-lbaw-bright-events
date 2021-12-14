<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;


  /**
   * The event organizer is
   */
  public function organizer() {
    return $this->belongsTo('App\Models\User');
  }

  /**
   * The cover image file is
   */
  public function image() {
    return $this->belongsTo('App\Models\File');
  }

  /**
   * Comments of event
   */
  public function comments() {
    return $this->hasMany('App\Models\Comment');
  }
}
