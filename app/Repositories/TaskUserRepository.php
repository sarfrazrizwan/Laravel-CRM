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
use App\Task;
use App\User;

class TaskUserRepository
{
    public function store(Task $task, User $user)
    {
        return $task->users()->syncWithoutDetaching($user);
    }
    public function destroy(Task $task, User $user)
    {
        return $task->users()->detach($user);
    }
}