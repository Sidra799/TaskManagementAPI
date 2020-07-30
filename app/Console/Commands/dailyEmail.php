<?php

namespace App\Console\Commands;

use App\Http\Controllers\TaskController;
use App\Events\EmailDelayedTasks;

use Illuminate\Console\Command;

class dailyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:Email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email to User if the task is not completed as per completion date';

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
        $tasks = TaskController::checkDelayedTask();
        foreach ($tasks as $task) {
            foreach ($task['users'] as $user) {
               echo "hello";
                    event(new EmailDelayedTasks($user->email,$user->name,$task['taskId'],$user->designation));
                
            }
        }
    }
}
