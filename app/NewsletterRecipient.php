<?php

namespace App;

use App\Helpers\DateTimeHelper;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class NewsletterRecipient extends Model
{
    use UUID;
    protected $guarded = ['id', 'uuid'];

    public function getCreatedDateAttribute()
    {
        return DateTimeHelper::getDateTime($this->created_at);
    }
    public function recipient()
    {
        return $this->belongsTo(Customer::class,'recipient_id');
    }
    public function newsletter()
    {
        return $this->belongsTo(Newsletter::class);
    }
}
