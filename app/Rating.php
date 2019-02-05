<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
  protected $table = 'ratings';

  protected $fillable = array( 'user_id', 'image_id');

  public function user() {
      return $this->belongsTo('App\User');
}
}
