<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 9/17/2020
 * Time: 3:46 PM
 */

namespace App\Repositories;


use App\Newsletter;

class NewsletterRepository extends BaseRepository
{

    public function __construct(Newsletter $newsletter)
    {
        $this->model = $newsletter;
    }

    public function index()
    {
        $search = \request('query');
        $perPage = \request('perPage') ?? null;
        $query = $this->model->query();
        $query->with('company');


        if ($search)
        {
            $query->where('name', 'like', "%$search%")
                ->orWhere('subject', 'like', "%$search%");
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
                'subject' => $attributes['subject'],
                'content' => $attributes['content'],
                'company_group_ids' => $attributes['company_group_ids']
            ]
        );
    }
}