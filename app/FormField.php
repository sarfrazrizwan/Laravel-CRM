<?php

namespace App;

use App\Helpers\DateTimeHelper;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    use UUID;
    protected $guarded = ['id', 'uuid'];

    public static function sortOrderNumber($formId)
    {
        $max = self::where('form_id', $formId)->max('sort_order');
        return $max ? ++$max : 1;
    }
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
    public function getCreatedDateAttribute()
    {
        return DateTimeHelper::getDateTime($this->created_at);
    }
}
