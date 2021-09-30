<?php

namespace App;

use App\Helpers\DateTimeHelper;
use App\Scopes\CompanyScope;
use App\Traits\UUID;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use UUID {
        boot as traitBoot;
    }
    use Sluggable;
    protected $guarded = ['id', 'uuid'];

    protected static function boot()
    {
        self::traitBoot();
        static::addGlobalScope(new CompanyScope());
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function getCreatedDateAttribute()
    {
        return DateTimeHelper::getDateTime($this->created_at);
    }
    public function fields()
    {
        return $this->hasMany(FormField::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
