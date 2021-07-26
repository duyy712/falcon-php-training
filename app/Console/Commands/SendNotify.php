<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SendEmailNotification;
use Illuminate\Console\Command;

class SendNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to the users daily';

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
        User::all()->each(function ($user) {
            $user->notify(new SendEmailNotification());
        });
    }
}
