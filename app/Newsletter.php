<?php

namespace App;

use App\Enums\NewsletterStatus;
use App\Helpers\DateTimeHelper;
use App\Scopes\CompanyScope;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use UUID {
        boot as traitBoot;
    }
    protected $guarded = ['id', 'uuid'];
    protected $casts = [
        'company_group_ids' => 'array',
        'user_types' => 'array',
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

    public function getStatusValueAttribute()
    {
        return NewsletterStatus::getKey($this->status);
    }
//    public function getUserTypesValueAttribute()
//    {
//        return Role::whereIn('name', $this->user_types)->get()->pluck('name')->toArray();
//    }
    public function getCompanyGroupsValueAttribute()
    {
        return CompanyGroup::whereIn('uuid', $this->company_group_ids)->get()->pluck('name')->toArray();
    }
    public function recipients()
    {
        return $this->hasMany(NewsletterRecipient::class);
    }
}
