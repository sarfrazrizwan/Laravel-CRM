<?php

namespace App;

use App\Enums\UserType;
use App\Helpers\DateTimeHelper;
use App\Scopes\CompanyScope;
use App\Traits\UUID;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use HasApiTokens;

    use UUID {
        boot as traitBoot;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'meta' => 'array'
    ];

    protected static function boot()
    {
        self::traitBoot();
        static::addGlobalScope(new CompanyScope());
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(UserType::SUPER_ADMIN);
    }
    public function isCompanyAdmin(): bool
    {
        return $this->hasRole(UserType::COMPANY_ADMIN);
    }
    public function getNameAttribute()
    {
        return "$this->first_name $this->last_name";
    }
    public function getImagePathAttribute()
    {
        if($this->image)
            return asset('images/users/'.$this->image);
        return asset('images/user-blank.png');
    }
    public function getCreatedDateAttribute()
    {
        return DateTimeHelper::getDateTime($this->created_at);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function companyGroups()
    {
        return $this->belongsToMany(CompanyGroup::class);
}


}
