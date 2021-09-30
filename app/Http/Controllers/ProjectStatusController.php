<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectStatusRequest;
use App\Http\Resources\ProjectStatusCollection;
use App\Http\Resources\ProjectStatusResource;
use App\Repositories\ProjectStatusRepository;

class ProjectStatusController extends Controller
{
    private $projectStatusRepo;

    public function __construct(ProjectStatusRepository $repository)
    {
        $this->projectStatusRepo = $repository;
    }

    public function index()
    {
        return new ProjectStatusCollection($this->projectStatusRepo->index());
    }
    public function updateOrCreate(StoreProjectStatusRequest $request)
    {
        $data = $request->all();
        $data['company_id'] = auth()->user()->company_id;
        return new ProjectStatusResource($this->projectStatusRepo->updateOrCreate($data));
    }
    public function show($uuid)
    {
        return $this->projectStatusRepo->show($uuid);
    }
    public function destroy($uuid)
    {
        $this->projectStatusRepo->destroy($uuid);
        return json_response(__('api.PROJECT_STATUS_DELETED'));
    }
    public function all()
    {
        return new ProjectStatusCollection($this->projectStatusRepo->all());
    }
}
