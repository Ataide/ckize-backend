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

    public static function getTotalCountFeedsForUser($userIds)
  	{
  		return self::whereIn('user_id', $userIds)->count();
  	}

}
