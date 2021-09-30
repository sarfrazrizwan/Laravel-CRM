<?php


namespace App\Traits;


trait UUID
{
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = str_replace('-', '', (string) \Webpatser\Uuid\Uuid::generate(4));
        });
    }
    public function scopeWhereUUID($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }
    public static function findByUUID($uuid, array $columns = ['*'])
    {
        return static::whereUUID($uuid)->first($columns);
    }
    public static function findByUUIDOrFail($uuid, array $columns = ['*'])
    {
        return static::whereUUID($uuid)->firstOrFail($columns);
    }
}
