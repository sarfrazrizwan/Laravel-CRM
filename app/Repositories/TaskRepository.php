<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 8/12/2020
 * Time: 4:23 PM
 */

namespace App\Repositories;


use App\Task;

class TaskRepository extends BaseRepository
{

    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function index($attributes = [])
    {
        $search = \request('query');
        $perPage = \request('perPage') ?? 10;
        $query = $this->model->query();
        $query->with(['status', 'author', 'project']);
        $query->withCount('users');

        $assignTo = $attributes['assign_to'] ?? null;
        $createdBy = $attributes['created_by'] ?? null;

        $authUser = auth()->user();
        if (!$authUser->isSuperAdmin() && !$authUser->isCompanyAdmin())
            $query = $this->filterAssignTo($query, $authUser->id);
        elseif ($assignTo)
            $query = $this->filterAssignTo($query, $assignTo);

        if ($search)
            $query->where('title', 'like', "%$search%");

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
        if ($filterBy == 'over_due')
            $query->where('deadline', '<', now());
        elseif ($filterBy == 'due_today')
            $query->whereDate('deadline', today());

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
            'task_status_id' => $attributes['task_status_id'],
            'deadline' => $attributes['deadline'],
            'additional_fields' => $attributes['fields'] ?? null
        ];
        if (! $attributes['id'])
            $data['user_id'] = $attributes['user_id'];

        return $this->model->updateOrCreate(
            [
                'uuid' => $attributes['id'] ?? null,
                'company_id' => $attributes['company_id'],
                'project_id' => $attributes['project_id'],
            ],
            $data
        );
    }

}