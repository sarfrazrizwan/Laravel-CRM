<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 8/11/2020
 * Time: 1:51 PM
 */

namespace App\Repositories;


use App\Enums\UserType;
use App\User;

class UserRepository
{
    protected $model;
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function index()
    {
        $search = \request('query');
        $perPage = \request('perPage') ?? 10;
        $query = $this->model->query();
        $query->where('id','<>', auth()->id());
        $query->with('company');


        if ($search)
        {
            $query->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $query->orderBy('created_at','desc');
       return $query->paginate($perPage);
    }
    public function show($uuid)
    {
        return $this->model->findByUUIDOrFail($uuid);

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
            'user_type' => $attributes['user_type'],
        ];

        if(isset($attributes['password']))
            $data['password'] = bcrypt($attributes['password']);


        $user = $this->model->updateOrCreate(
            [
                'uuid' => isset($attributes['id']) ? $attributes['id'] : null ,
            ],
            $data
        );

        return $user;
    }
    public function destroy($uuid)
    {
        return $this->model->findByUUIDOrFail($uuid)->delete();
    }
}