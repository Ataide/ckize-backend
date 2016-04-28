<?php

namespace App\Console\Commands;

use App\Realtime\Events as SocketClient;
use App\User;
use Illuminate\Console\Command;
use JWTAuth;

class LoginUserNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:login {token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify Login for all friends related User';

    protected $token;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
      parent::__construct();
      $this->socketClient = new SocketClient;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $user = JWTAuth::toUser($this->argument('token'));
      $friendsUserIds = $user->friends()->where('online_status', 1)->lists('requester_id');
      $relatedToId = $user->id;
      $clientCode = 22;
      $message = 'is now online';
      $this->socketClient->updateChatStatusBar($friendsUserIds, $clientCode, $relatedToId, $message);


      $user->online_status = 1;
      $user->save();
        //
    }
}
