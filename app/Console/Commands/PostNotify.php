<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Realtime\Events as SocketClient;
use App\User;
use JWTAuth;

class PostNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:post {token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify a new post for all friends related User';

    protected $token;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->socketClient = new SocketClient();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $user = JWTAuth::toUser($this->argument('token'));
      $friendsUserIds = $user->friends()->where('online_status',1)->lists('requester_id');      
      $relatedToId = $user->id;
      $clientCode = 41;
      $message = $user->name." escreveu um novo post.";
      $this->socketClient->notifyNewPost($friendsUserIds,$clientCode,$relatedToId,$message);

    }
}
