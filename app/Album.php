<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';

    protected $fillable = array('name','description','cover_image', 'user_id','stars');

    public function Photos(){
        return $this->hasMany('App\Image');
    }

    public function user() {
        return $this->belongsTo('App\User');
      }

      public function accessalbum(){
          return $this->hasMany('App\AccessAlbum');
      }

      public function comments(){
          return $this->hasMany('App\CommentsAlbum');
      }
}
