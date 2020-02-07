<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiaforum:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quickly generate a login access token for development use';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->ask('Please input a user ID');

        $user = User::find($userId);

        if(!$user){
            return $this->error('The input user does not exist.');
        }

        //Set the tokem's expire date as one year later
        $ttl = 365 * 24 * 60;
        $this->info(auth('api')->setTTL($ttl)->login($user));
    }
}
