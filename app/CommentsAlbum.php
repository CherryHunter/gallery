<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentsAlbum extends Model
{
    protected $table = 'comments_albums';

      protected $fillable = array('description', 'user_id', 'album_id');

    public function user() {
      	return $this->belongsTo('App\User');
      }

}
