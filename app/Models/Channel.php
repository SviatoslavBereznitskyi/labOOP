<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Channels.
 *
 * @property string|null username
 * @property string service
 * @property string title
 * @package namespace App\Models;
 */
class Channel extends Model implements Transformable
{
    use TransformableTrait;

    const TWITTER_SERVICE  = 'Twitter';
    const FACEBOOK_SERVICE = 'Facebook';
    const TELEGRAM_SERVICE = 'Telegram';

    protected $guarded = [];

    public function scopeByService(Builder $query, $service)
    {
        return $query->where('service', $service);
    }

    public function telegramUsers()
    {
        return $this->belongsToMany(TelegramUser::class);
    }

    /**
     * @return string|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function change(array $params)
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    public function getService()
    {
        return $this->service;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
