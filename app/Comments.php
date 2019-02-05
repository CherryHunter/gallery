<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
  protected $table = 'comments';

  protected $fillable = array('description', 'user_id', 'image_id');

  public function user() {
    	return $this->belongsTo('App\User');
    }


}
