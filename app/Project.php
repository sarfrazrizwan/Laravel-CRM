<?php

namespace App;

use App\Enums\ProjectType;
use App\Helpers\DateTimeHelper;
use App\Scopes\CompanyScope;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use UUID {
        boot as traitBoot;
    }

    protected $guarded = ['id', 'uuid'];
    protected $casts = [
        'additional_fields' => 'array'
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
    public function getTypeValueAttribute()
    {
        return ProjectType::getKey($this->type);
    }
    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
