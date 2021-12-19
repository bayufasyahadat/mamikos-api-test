<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class Credit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:autocredits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scheduler to auto recharge credits';

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
     * @return int
     */
    public function handle()
    {
        $users = User::where('role', 2)->update(['credit' => 20]);
        $users = User::where('role', 3)->update(['credit' => 40]);

        $this->info('Command success.');
    }
}
