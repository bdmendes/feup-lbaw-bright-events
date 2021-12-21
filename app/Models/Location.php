<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
  // Don't add create and update timestamps in database.
  public $timestamps  = false;
  protected $table = 'location';


}
