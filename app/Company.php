<?php

namespace App;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use UUID;
    protected $perPage = 10;
    protected $guarded = [];

}
