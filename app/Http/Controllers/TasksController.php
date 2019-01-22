<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Storage;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function index(TaskService $taskService)
    {
        $tasks = $taskService->getList();
        return view('tasks.index', compact('tasks'));
    }

    public function add()
    {
        return view('tasks.add');
    }

    public function store(Request $request, TaskService $taskService)
    {
        $taskStoreResult = $taskService->addNewTask($request->all());

        if ($taskStoreResult['validator']->fails()) {
            return redirect('tasks/add')
                ->withErrors($taskStoreResult['validator'])
                ->withInput();
        }

        return redirect('/tasks')->withHeaders([
            'task-id' => $taskStoreResult['task']->id
        ]);
    }

    public function download($taskId, TaskService $taskService)
    {
        $taskDownloadResult = $taskService->downloadTask($taskId);
        if (isset($taskDownloadResult['errors']) && $taskDownloadResult['errors']) {
            return abort(404);
        }
        return $taskDownloadResult['download'];
    }
}
