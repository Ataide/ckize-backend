<?php namespace App\Repositories\User;

use App\User;

class EloquentUserRepository implements UserRepository
{

	/**
	 * Fetch a user by id
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	public function findById($id)
	{
		return User::find($id);
	}

	/**
	 * Fetch many users by id
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	public function findManyById(array $ids)
	{
		$users = [];

		foreach ($ids as $id) {

			$users[] = User::find($id);
		}

		return	$users;
	}


	/**
	 * Fetch a user by id with feeds attached
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	public function findByIdWithFeeds($id)
	{
		return User::with([
			'feeds' => function($query){
			$query->latest();
		}])->findOrFail($id);
	}


	/**
	 * Fetch a user by id with emails attached
	 *
	 * @param int $id
	 *
	 * @return mixed
	 */
	public function findByIdWithMessages($id)
	{
		return User::find($id)->messages()->paginate(10);
	}
	/**
	 * Fetch friend requests for a user
	 *
	 * @param int $userId
	 *
	 * @return mixed
	 */
	public function findByIdWithFriendRequests($userId)
	{
		$user = User::with([
			'friendRequests' => function($query){
			$query->latest();
		}])->findOrFail($userId)->toArray();
		return $user['friend_requests'];
	}

	/**
	 * Fetch friends for a user
	 *
	 * @param int $userId
	 *
	 * @return mixed
	 */
	public function findByIdWithFriends($userId)
	{
		$user = User::with([
			'friends' => function($query){
			$query->orderBy('name', 'desc');
		}])->findOrFail($userId)->toArray();

		return $user['friends'];
	}

}
