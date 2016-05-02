<?php namespace App\Repositories\Feed;

use App\User;
use App\Feed;
use App\Post;

class EloquentFeedRepository implements FeedRepository
{
	/**
	 * Get feeds posted by current user and friends.
	 *
	 * 	@param User $user
	 *
	 *	@return mixed
	 */
	public function getPublishedByUserAndFriends(User $user)
	{
		$friendsUserIds = $user->friends()->lists('requester_id');

		$friendsUserIds[] = $user->id;

		return Post::whereIn('user_id', $friendsUserIds)->latest()->take(10)->get();

	}

	public function getPublishedByUser(User $user)
	{
		return $user->feeds()->paginate(8);

	}

	public function updateNameInPosts(User $user){
		$posts = $user->posts()->get();
		foreach ($posts as $post) {
			$post->poster_firstname = $user->name;
			$post->save();
		}
		return true;

	}


	/**
	 * Get feeds posted by current user and friends via ajax.
	 *
	 * 	@param User $user
	 *
	 * 	@param int $startingPoint
	 *
	 *	@return mixed
	 */
	public function getPublishedByUserAndFriendsAjax(User $user, $skipQty)
	{
		$friendsUserIds = $user->friends()->lists('requester_id');

		$friendsUserIds[] = $user->id;

		return Feed::whereIn('user_id', $friendsUserIds)->latest()->skip($skipQty)->take(10)->get();
	}

}
