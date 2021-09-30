<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Requests\StoreProjectCommentRequest;
use App\Http\Resources\ProjectCommentResource;
use App\Http\Resources\ProjectResouce;
use App\Project;
use App\ProjectStatus;
use App\Repositories\CommentRepository;
use App\Repositories\ProjectCommentRepository;

class ProjectCommentController extends Controller
{
    private $repo;
    public function __construct(CommentRepository $repository)
    {
        $this->repo = $repository;
    }

    public function store(StoreProjectCommentRequest $request, $projectId)
    {
        $data = $request->all();
        $project = Project::findByUUIDOrFail($projectId);
        $data['user_id'] = auth()->id();
        return (new ProjectCommentResource($this->repo->store($data, $project)))->additional([
            'message' => __('api.COMMENT_CREATED')
        ]);
    }
    public function destroy($uuid)
    {
        $this->repo->destroy($uuid);
        return json_response(__('api.COMMENT_DELETED'));
    }
}
