<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 8/12/2020
 * Time: 4:45 PM
 */

namespace App\Repositories;


class BaseRepository
{
    protected $model;

    public function all()
    {
        return $this->model->get();
    }
    public function show($uuid)
    {
        return $this->model->findByUUIDOrFail($uuid);

    }
    public function destroy($uuid)
    {
        return $this->model->findByUUIDOrFail($uuid)->delete();
    }
}