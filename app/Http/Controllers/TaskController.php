<?php

namespace App\Http\Controllers;

use App\Helpers\DateTimeHelper;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Project;
use App\Repositories\TaskRepository;
use App\TaskStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $repo;
    public function __construct(TaskRepository $repository)
    {
        $this->repo = $repository;
    }

    public function index()
    {
        $attributes = [];
        $assignedMe = (bool) request('assigned');
        $myTasks = (bool) request('mine');

        if ($assignedMe)
            $attributes['assign_to'] = auth()->id();
        if ($myTasks)
            $attributes['created_by'] = auth()->id();

        return new TaskCollection($this->repo->index($attributes));
    }
    public function updateOrCreate(StoreTaskRequest $request)
    {
        info(DateTimeHelper::getDateTime($request->deadline));
        $projectId = null;
        if ($request->project_id)
            $projectId = Project::findByUUIDOrFail($request->project_id)->id;

        $taskStatus = TaskStatus::findByUUIDOrFail($request->task_status_id);
        $data = $request->all();
        $data['company_id'] = auth()->user()->company_id;
        $data['user_id'] = auth()->user()->id;
        $data['task_status_id'] = $taskStatus->id;
        $data['project_id'] = $projectId;
        $data['deadline'] = Carbon::createFromFormat('d-m-Y H:i', $request->deadline);
        return new TaskResource($this->repo->updateOrCreate($data));
    }
    public function show($uuid)
    {
        return new TaskResource($this->repo->show($uuid));
    }
    public function destroy($uuid)
    {
        $this->repo->destroy($uuid);
        return response()->json(['message' => __('api.TASK_DELETED')]);
    }
}
