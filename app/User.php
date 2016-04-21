<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany('\App\Post');
    }

    public function profile()
    {
      return $this->hasOne('\App\Profile');
    }

    public function friendRequests()
  	{
  		return $this->hasMany('\App\FriendRequest');
  	}

    public function friends()
  	{
  		return $this->belongsToMany(Self::class, 'friends', 'requested_id', 'requester_id')->withTimestamps();
  	}

  	public function createFriendShipWith($requesterUserId)
  	{
  		return $this->friends()->attach($requesterUserId, ['requested_id' => $this->id, 'requester_id' => $requesterUserId]);
  	}  	

  	public function finishFriendshipWith($requesterUserId)
  	{
  		return $this->friends()->detach($requesterUserId, ['requested_id' => $this->id, 'requester_id' => $requesterUserId]);
  	}







    public function allUsers()
    {
        return self::all();
    }

    public function getUser($id)
    {
        $user = self::find($id);
        return $user;
    }


}
