<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 8/12/2020
 * Time: 4:23 PM
 */

namespace App\Repositories;


use App\CompanyGroup;

class CompanyGroupRepository extends BaseRepository
{

    public function __construct(CompanyGroup $companyGroup)
    {
        $this->model = $companyGroup;
    }

    public function index()
    {
        $search = \request('query');
        $perPage = \request('perPage') ?? 10;
        $query = $this->model->query();
        $query->with('company');
        $query->withCount('customers');


        if ($search)
        {
            $query->where('name', 'like', "%$search%");
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
                'name' => $attributes['name'],
                'description' => $attributes['description'] ?? null,
            ]
        );
    }

}