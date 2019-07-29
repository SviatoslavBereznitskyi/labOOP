<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    public $timestamps = false;

    protected $fillable =[
        'key',
        'value',
    ];

    /**
     * @param null $key
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Support\Collection
     */
    public static function getSettings($key = null)
    {  return $key
            ? self::query()->where('key', $key)->first()
            : self::query()->get()->pluck('value', 'key');
    }
}
