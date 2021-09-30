<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 9/21/2020
 * Time: 6:04 PM
 */

namespace App\Repositories;


use App\Form;

class FormRepository extends BaseRepository
{
    public function __construct(Form $form)
    {
        $this->model = $form;
    }
    public function index()
    {
        $search = \request('query');
        $perPage = \request('perPage') ?? null;
        $query = $this->model->query();
        $query->with('company');
        $query->withCount('fields');


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
                'recaptcha' => $attributes['recaptcha'],
                'recaptcha_secret' => $attributes['recaptcha_secret'],
            ]
        );
    }
}