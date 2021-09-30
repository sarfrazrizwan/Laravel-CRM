<?php

namespace App;

use App\Helpers\DateTimeHelper;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use UUID;
    protected $guarded = ['id', 'uuid'];

    public function getCreatedDateAttribute()
    {
        return DateTimeHelper::getDateTime($this->created_at);
    }
    public function commentable()
    {
        return $this->morphTo();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
