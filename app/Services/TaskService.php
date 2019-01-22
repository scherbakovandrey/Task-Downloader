<?php

namespace App\Services;

use App\Task;
use App\Jobs\ProcessTask;
use App\Utils\FilenameExtractor;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Storage;
use Validator;

class TaskService
{
    public function getList($order = 'desc')
    {
        return (new Task)->getList($order);
    }

    public function addNewTask($attributes)
    {
        $validator = Validator::make($attributes, [
            'url' => ['required', 'min:15', 'url']
        ]);

        if ($validator->fails()) {
            return [
                'validator' => $validator
            ];
        }

        $task = Task::create($attributes);

        ProcessTask::dispatch($task);

        return [
            'validator' => $validator,
            'task' => $task
        ];
    }

    public function downloadTask($taskId)
    {
        $validator = Validator::make(['id' => $taskId], [
            'id' => ['required', 'min:1', 'integer']
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errorMessages = [];
            foreach ($errors->all() as $message) {
                $errorMessages[] = $message;
            }
            return [
                'errors' => $errorMessages[0]
            ];
        }

        try
        {
            $task = Task::findOrFail($taskId);
        }
        catch(ModelNotFoundException $e)
        {
            return ['errors' => 'This task is not found!'];
        }

        if (!$task->isCompleted())
        {
            return ['errors' => 'This task is not completed!'];
        }

        $storageFilename = FilenameExtractor::extract($task->url, $task->id);
        $originalFilename = FilenameExtractor::clear($storageFilename, $task->id);

        if (Storage::exists($storageFilename)) {
            return [
                'storageFilename' => storage_path() . '\\app\\' . $storageFilename,
                'download' => Storage::download($storageFilename, $originalFilename),
                'errors' => ''
            ];
        } else {
            return ['errors' => 'This task is not exists!'];
        }
    }
}
