<?php

namespace App\Console\Commands;
use App\User;

use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $request = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = new User();
        $user->email = $request['email'];
        $user->save();
        return 'Executei o Commando';
    }
}
