<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // $fillable['title', 'text'];

    public function user()
    {
      return $this->belongsTo('\App\User');
    }
}
