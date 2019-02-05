<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessImage extends Model
{
  protected $table = 'access_images';

  protected $fillable = array( 'user_id', 'image_id');

  public function user() {
    	return $this->belongsTo('App\User');
    }

    public function accessuserss() //do jakich obrazkow ma dostep
  {
      return $this->belongsToMany('App\User');
  }
}
