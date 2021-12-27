<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRequest extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'attendance_request';

  /**
   * The Comment author is 
   */
  public function commenter() {
    return $this->belongsTo('App\Models\User');
  }

  public function event() {
    return $this->belongsTo('App\Models\Event');
  }



}