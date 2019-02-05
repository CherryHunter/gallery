<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessAlbum extends Model
{
  protected $table = 'access_albums';

  protected $fillable = array( 'user_id', 'album_id');

  public function user() {
      return $this->belongsTo('App\User');
    }

    public function accessuserss() //do jakich obrazkow ma dostep
  {
      return $this->belongsToMany('App\User');
  }
  
}
