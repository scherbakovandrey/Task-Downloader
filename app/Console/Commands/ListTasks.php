<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\TaskService;

class ListTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View list of download tasks with statuses';

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
    public function handle(TaskService $taskService)
    {
        $tasks = $taskService->getList('asc');
        if (count($tasks))
        {
            $headers = ['ID', 'Url', 'Status'];
            foreach ($tasks as $task)
            {
                $taskData[] = [
                    'id' => $task->id,
                    'url' => $task->url,
                    'status' => $task->getReadableStatus()
                ];
            }
            $this->table($headers, $taskData);
        } else {
            $this->info('Sorry, there are not any tasks!');
        }
    }

}
