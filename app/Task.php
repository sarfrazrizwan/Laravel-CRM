<?php

namespace App;

use App\Helpers\DateTimeHelper;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use UUID;
    protected $guarded = ['id', 'uuid'];

    protected $casts = [
        'deadline' => 'datetime',
        'additional_fields' => 'array'
    ];

    public function getCreatedDateAttribute()
    {
        return DateTimeHelper::getDateTime($this->created_at);
    }
    public function status()
    {
        return $this->belongsTo(TaskStatus::class, 'task_status_id');
    }
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
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
