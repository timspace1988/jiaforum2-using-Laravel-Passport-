<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CalculateActiveUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiaforum:calculate-active-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate active users and store in cache';

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
    public function handle(User $user)
    {
        //Print an info on command line
        $this->info("Start calculating");

        $user->calculateAndCacheActiveUsers();

        $this->info('Active users have been generated successfully.');
    }
}
