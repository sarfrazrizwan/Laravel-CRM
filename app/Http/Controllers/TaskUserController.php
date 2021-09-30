<?php

namespace App\Http\Controllers;

use App\Repositories\TaskUserRepository;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class TaskUserController extends Controller
{
    private $repo;

    public function __construct(TaskUserRepository $repository)
    {
        $this->repo = $repository;
    }

    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,uuid',
            'user_id' => 'required|exists:users,uuid',
        ]);

        $task = Task::findByUUIDOrFail($request->task_id);
        $user = User::findByUUIDOrFail($request->user_id);

        $this->repo->store($task, $user);
        return json_response(__('api.USER_ADDED_TO_TASK'));
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,uuid',
            'user_id' => 'required|exists:users,uuid',
        ]);

        $task = Task::findByUUIDOrFail($request->task_id);
        $user = User::findByUUIDOrFail($request->user_id);

        $this->repo->destroy($task, $user);

        return json_response(__('api.USER_REMOVED_FROM_TASK'));
    }
}
