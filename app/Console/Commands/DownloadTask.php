<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Validator;
use App\Services\TaskService;

class DownloadTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:download {taskid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download the task';

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
        $taskId = $this->argument('taskid');

        $taskDownloadResult = $taskService->downloadTask($taskId);

        if (isset($taskDownloadResult['errors']) && !empty($taskDownloadResult['errors'])) {
            $this->error($taskDownloadResult['errors']);
        } else {
            $pathToFile = $taskDownloadResult['storageFilename'];
            echo file_get_contents($pathToFile);
        }
    }
}
