<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
      $this->app->bind(
  			'App\Repositories\Feed\FeedRepository',
  			'App\Repositories\Feed\EloquentFeedRepository'
  		);

  		//Uncomment if you don't wish to cache all users
  		$this->app->bind(
  			'App\Repositories\User\UserRepository',
  			'App\Repositories\User\EloquentUserRepository'
  		);

  		$this->app->bind(
  			'App\Repositories\FriendRequest\FriendRequestRepository',
  			'App\Repositories\FriendRequest\EloquentFriendRequestRepository'
  		);

  		$this->app->bind(
  			'App\Repositories\Message\MessageRepository',
  			'App\Repositories\Message\EloquentMessageRepository'
  		);

  		$this->app->bind(
  			'MessageRequest',
  			'App\Http\Requests\CreateMessageRequest'
  		);

  		$this->app->bind(
  			'MessageResponseRequest',
  			'App\Http\Requests\CreateMessageResponseRequest'
  		);
    }
}
