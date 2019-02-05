<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = array('album_id','description','image', 'user_id','rights','rating','stars');

    public function Icomments(){
        return $this->hasMany('App\Comments');
    }

    public function user() {
        return $this->belongsTo('App\User');
      }



      public function accessimage(){
          return $this->hasMany('App\AccessImage');
      }
}
