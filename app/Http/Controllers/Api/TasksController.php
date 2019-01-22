<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Storage;
use App\Services\TaskService;

class TasksController extends Controller
{
    public function index(TaskService $taskService)
    {
        return $taskService->getList();
    }

    public function store(Request $request, TaskService $taskService)
    {
        $taskResult = $taskService->addNewTask($request->all());

        if ($taskResult['validator']->fails()) {
            $errors = $taskResult['validator']->errors();

            $errorMessages = [];
            foreach ($errors->all() as $message) {
                $errorMessages[] = $message;
            }

            return (new Response)->setStatusCode(406)->setContent(['errors' => $errorMessages]);
        }

        return (new Response)->setStatusCode(201)->setContent(
            [
                'id' => $taskResult['task']->id,
                'uri' => '/tasks/' . $taskResult['task']->id,
                'message' => 'The new task is successfully created!'
            ]
        );
    }

    public function download($taskId, TaskService $taskService)
    {
        $taskDownloadResult = $taskService->downloadTask($taskId);
        if (isset($taskDownloadResult['errors']) && !empty($taskDownloadResult['errors'])) {
            return (new Response)->setStatusCode(404)->setContent(['errors' => $taskDownloadResult['errors']]);
        }
        return $taskDownloadResult['download'];
    }
}