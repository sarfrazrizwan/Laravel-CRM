<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResouce;
use App\ProjectStatus;
use App\Repositories\ProjectRepository;

class ProjectController extends Controller
{
    private $projectRepo;
    public function __construct(ProjectRepository $repository)
    {
        $this->projectRepo = $repository;
    }

    public function index()
    {
        $attributes = [];
        $assignedMe = (bool) request('assigned');
        $myProjects = (bool) request('mine');
        if ($assignedMe)
            $attributes['assign_to'] = auth()->id();
        if ($myProjects)
            $attributes['created_by'] = auth()->id();

        return new ProjectCollection($this->projectRepo->index($attributes));
    }
    public function updateOrCreate(StoreProjectRequest $request)
    {
        $projectStatus = ProjectStatus::findByUUIDOrFail($request->project_status_id);
        $data = $request->all();
        $data['company_id'] = auth()->user()->company_id;
        $data['user_id'] = auth()->user()->id;
        $data['project_status_id'] = $projectStatus->id;
        return new ProjectResouce($this->projectRepo->updateOrCreate($data));
    }
    public function show($uuid)
    {
        return new ProjectResouce($this->projectRepo->show($uuid));
    }
    public function destroy($uuid)
    {
        $this->projectRepo->destroy($uuid);
        return response()->json(['message' => __('api.PROJECT_DELETED')]);
    }
    public function all()
    {
        return new ProjectCollection($this->projectRepo->all());
    }
}
