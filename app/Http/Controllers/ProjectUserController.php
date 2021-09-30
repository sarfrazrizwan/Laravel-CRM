<?php

namespace App\Http\Controllers;

use App\Project;
use App\Repositories\ProjectUserRepository;
use App\User;
use Illuminate\Http\Request;

class ProjectUserController extends Controller
{
    private $repo;

    public function __construct(ProjectUserRepository $repository)
    {
        $this->repo = $repository;
    }

    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,uuid',
            'user_id' => 'required|exists:users,uuid',
        ]);

        $project = Project::findByUUIDOrFail($request->project_id);
        $user = User::findByUUIDOrFail($request->user_id);

        $this->repo->store($project, $user);
        return json_response(__('api.USER_ADDED_TO_PROJECT'));
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,uuid',
            'user_id' => 'required|exists:users,uuid',
        ]);

        $project = Project::findByUUIDOrFail($request->project_id);
        $user = User::findByUUIDOrFail($request->user_id);

        $this->repo->destroy($project, $user);

        return json_response(__('api.USER_REMOVED_FROM_PROJECT'));
    }
}
