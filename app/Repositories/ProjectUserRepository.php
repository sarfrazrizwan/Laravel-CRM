<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 8/12/2020
 * Time: 4:23 PM
 */

namespace App\Repositories;


use App\CompanyGroup;
use App\Project;
use App\User;

class ProjectUserRepository
{
    public function store(Project $project, User $user)
    {
        return $project->users()->syncWithoutDetaching($user);
    }
    public function destroy(Project $project, User $user)
    {
        return $project->users()->detach($user);
    }
}