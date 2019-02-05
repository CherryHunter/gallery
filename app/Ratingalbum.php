<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ratingalbum extends Model
{
  protected $table = 'ratingsalbums';

  protected $fillable = array( 'user_id', 'album_id');

  public function user() {
      return $this->belongsTo('App\User');
}
}
