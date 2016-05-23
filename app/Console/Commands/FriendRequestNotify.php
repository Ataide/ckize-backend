<?php

namespace App\Console\Commands;

use App\Realtime\Events as SocketClient;
use App\User;
use Illuminate\Console\Command;
use JWTAuth;

class FriendRequestNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:friend_request {data}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify User to a new FriendRequest';

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
        $data = $this->argument('data');
        $user = JWTAuth::toUser($data['token']);
        $friendUserId = $data['userId'];
        $relatedToId = $user->id;
        $clientCode = 51;
        $message = $user->name." enviou uma solicitação de amizade";
        $this->socketClient->notifyNewFriendRequest($friendUserId,$clientCode,$relatedToId,$message);
        //
    }
}
