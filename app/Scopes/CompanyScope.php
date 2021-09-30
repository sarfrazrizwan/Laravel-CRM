<?php
/**
 * Created by PhpStorm.
 * User: Raheel Sarfraz
 * Date: 8/12/2020
 * Time: 2:43 PM
 */

namespace App\Scopes;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompanyScope implements Scope
{
    public function __construct()
    {
//        logger(["user" => request()->header("authorization")]);
    }

    public function apply(Builder $builder, Model $model)
    {
        if (Auth::check())
        {
            $user = Auth::user();
            if(! $user->isSuperAdmin())
                $builder->where('company_id',  $user->company_id)->whereNotNull('company_id');
        }

    }
}