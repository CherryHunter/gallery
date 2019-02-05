<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password','permissions',
    ];

	public $timestamps = false;

  public function Uimages(){
      return $this->hasMany('App\Image');
  }

  public function Ualbums(){
      return $this->hasMany('App\Album');
  }

  public function Ucomments(){
      return $this->hasMany('App\Comments');
  }

  public function comments(){
      return $this->hasMany('App\CommentsAlbum');
  }

  public function accessimages() //do jakich obrazkow ma dostep
{
    return $this->belongsToMany('App\Image');
}

}
