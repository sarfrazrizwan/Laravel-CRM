<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 8/11/2020
 * Time: 1:51 PM
 */

namespace App\Repositories;


use App\Template;

class TemplateRepository extends BaseRepository
{
    protected $model;
    public function __construct(Template $template)
    {
        $this->model = $template;
    }

    public function index()
    {
        $search = \request('query');
        $perPage = \request('perPage') ?? 10;
        $query = $this->model->query();

        $query->with(['company']);

        if ($search)
            $query->where('name', 'like', "%$search%");

        $query->orderBy('created_at','desc');
       return $query->paginate($perPage);
    }

    public function updateOrCreate(array $attributes)
    {
        $data = [
            'name' => $attributes['name'],
            'company_id' => $attributes['company_id'],
            'fields' => $attributes['fields'],

        ];

        $user = $this->model->updateOrCreate(
            [
                'uuid' => $attributes['id'] ?? null,
            ],
            $data
        );

        return $user;
    }

}