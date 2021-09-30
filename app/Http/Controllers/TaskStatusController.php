<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskStatusRequest;
use App\Http\Resources\TaskStatusCollection;
use App\Http\Resources\TaskStatusResource;
use App\Repositories\TaskStatusRepository;

class TaskStatusController extends Controller
{
    private $repo;

    public function __construct(TaskStatusRepository $repository)
    {
        $this->repo = $repository;
    }

    public function index()
    {
        return new TaskStatusCollection($this->repo->index());
    }
    public function updateOrCreate(StoreTaskStatusRequest $request)
    {
        $data = $request->all();
        $data['company_id'] = auth()->user()->company_id;
        return new TaskStatusResource($this->repo->updateOrCreate($data));
    }
    public function show($uuid)
    {
        return $this->repo->show($uuid);
    }
    public function destroy($uuid)
    {
        $this->repo->destroy($uuid);
        return json_response(__('api.TASK_STATUS_DELETED'));
    }
    public function all()
    {
        return new TaskStatusCollection($this->repo->all());
    }
}
