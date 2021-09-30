<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskCommentRequest;
use App\Http\Resources\TaskCommentResource;
use App\Repositories\CommentRepository;
use App\Task;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    private $repo;
    public function __construct(CommentRepository $repository)
    {
        $this->repo = $repository;
    }

    public function store(StoreTaskCommentRequest $request, $taskId)
    {
        $data = $request->all();
        $task = Task::findByUUIDOrFail($taskId);
        $data['user_id'] = auth()->id();
        return (new TaskCommentResource($this->repo->store($data, $task)))->additional([
            'message' => __('api.COMMENT_CREATED')
        ]);
    }
    public function destroy($uuid)
    {
        $this->repo->destroy($uuid);
        return json_response(__('api.COMMENT_DELETED'));
    }
}
