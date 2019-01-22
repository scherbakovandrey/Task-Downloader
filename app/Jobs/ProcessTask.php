<?php

namespace App\Jobs;

use Exception;
use App\Task;
use App\Utils\FilenameExtractor;
use Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessTask implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->task->downloading();

        $url = $this->task->url;

        $content = file_get_contents($url);
        if ($content === false) {
            $this->task->error();
        }

        $storageFilename = FilenameExtractor::extract($url, $this->task->id);
        Storage::put($storageFilename, $content);

        $this->task->complete();
    }

    public function failed(Exception $exception)
    {
        $this->task->error();
    }
}
