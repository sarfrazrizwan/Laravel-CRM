<?php

namespace App;

use App\Helpers\DateTimeHelper;
use App\Scopes\CompanyScope;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use UUID {
        boot as traitBoot;
    }
    protected $guarded = ['id', 'uuid'];

    protected $casts = [
        'fields' => 'array'
    ];

    protected static function boot()
    {
        self::traitBoot();
        static::addGlobalScope(new CompanyScope());
    }

    public function getCreatedDateAttribute()
    {
        return DateTimeHelper::getDateTime($this->created_at);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
