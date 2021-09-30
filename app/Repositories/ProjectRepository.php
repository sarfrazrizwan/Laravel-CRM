<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 8/12/2020
 * Time: 4:23 PM
 */

namespace App\Repositories;


use App\Project;

class ProjectRepository extends BaseRepository
{

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function index($attributes = [])
    {
        $perPage = \request('perPage') ?? 10;
        $query = $this->model->query();
        $query->with(['status', 'author']);
        $query->withCount('users');

        $assignTo = $attributes['assign_to'] ?? null;
        $createdBy = $attributes['created_by'] ?? null;

        $authUser = auth()->user();

        if ((!$authUser->isSuperAdmin() && !$authUser->isCompanyAdmin()) )
        {
           $query = $this->filterAssignTo($query, $authUser->id);
        }
        elseif ($assignTo)
        {
            $query = $this->filterAssignTo($query, $assignTo);
        }

        if ($createdBy)
            $query->where('user_id', $createdBy);

        $query = $this->indexFilter($query);
        $query->orderBy('created_at','desc');
        return $query->paginate($perPage);
    }
    private function indexFilter($query)
    {
        $search = \request('query');
        $filterBy = \request('filter_by');
        if ($search)
            $query->where('title', 'like', "%$search%");

        return $query;
    }
    private function filterAssignTo($query, $userId)
    {
        return $query->whereHas('users', function ($q) use($userId){
            $q->where('user_id', $userId);
        });
    }
    public function updateOrCreate(array $attributes)
    {
        $data = [
            'title' => $attributes['title'],
            'description' => $attributes['description'] ?? null,
            'project_status_id' => $attributes['project_status_id'],
            'type' => $attributes['type'],
            'additional_fields' => $attributes['fields'] ?? null,
        ];
        if (! $attributes['id'])
            $data['user_id'] = $attributes['user_id'];

        return $this->model->updateOrCreate(
            [
                'uuid' => $attributes['id'] ?? null,
                'company_id' => $attributes['company_id'],
            ],
            $data
        );
    }

}