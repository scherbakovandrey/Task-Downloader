<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Validator;
use App\Task;
use App\Services\TaskService;

class AddTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:add {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new task to the download queue';

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
    public function handle(Task $task, TaskService $taskService)
    {
        $url = $this->argument('url');

        $taskResult = $taskService->addNewTask([
            'url' => $url
        ]);

        if ($taskResult['validator']->fails()) {
            $errors = $taskResult['validator']->errors();
            foreach ($errors->all() as $message) {
                $this->error('Error: ' . $message);
            }
        } else {
            $this->info('The new task is succussfully added to the download queue!');
        }
    }
}
