<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 8/11/2020
 * Time: 1:51 PM
 */

namespace App\Repositories;


use App\Customer;

class CustomerRepository extends BaseRepository
{
    protected $model;
    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    public function index()
    {
        $search = \request('query');
        $perPage = \request('perPage') ?? 10;
        $query = $this->model->query();

        $query->with(['company','company_groups']);

        if ($search)
        {
            $query->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $query->orderBy('created_at','desc');
       return $query->paginate($perPage);
    }

    public function updateOrCreate(array $attributes)
    {
        $data = [
            'first_name' => $attributes['first_name'],
            'last_name' => $attributes['last_name'],
            'email' => $attributes['email'],
            'postal_code' => $attributes['postal_code'],
            'town' => $attributes['town'],
            'company_id' => $attributes['company_id'],
        ];

        $user = $this->model->updateOrCreate(
            [
                'uuid' => $attributes['id'] ?? null,
            ],
            $data
        );

        if(isset($attributes['company_group_ids']))
            $user->company_groups()->sync($attributes['company_group_ids']);

        return $user;
    }

}