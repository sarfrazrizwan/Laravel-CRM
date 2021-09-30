<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 8/12/2020
 * Time: 4:23 PM
 */

namespace App\Repositories;

use App\TaskStatus;

class TaskStatusRepository extends BaseRepository
{

    public function __construct(TaskStatus $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $search = \request('query');
        $perPage = \request('perPage') ?? 10;
        $query = $this->model->query();
        $query->with('company');

        if ($search)
        {
            $query->where('title', 'like', "%$search%");
        }

        $query->orderBy('created_at','desc');
        return $query->paginate($perPage);
    }

    public function updateOrCreate(array $attributes)
    {
        return $this->model->updateOrCreate(
            [
                'uuid' => $attributes['id'] ?? null,
                'company_id' => $attributes['company_id']
            ],
            [
                'title' => $attributes['title'],
            ]
        );
    }

}