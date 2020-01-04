<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class SyncUserActiveAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiaforum:sync-user-active-at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize the user last active time from Redis to database';

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
        $this->info('Start synchronizing');
        $user->syncUserActiveAt();
        //$this->info('User last active time has been synchronized successfully.');
        $this->info('Synchronized successfully.');
    }
}
