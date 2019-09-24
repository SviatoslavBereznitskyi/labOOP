<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property string|null first_name
 * @property string|null last_name
 * @property string|null username
 * @property string|null language_code
 * @property bool subscription
 */
class TelegramUser extends Model
{
    protected $guarded = [];

    public const TYPE_PRIVATE = 'private';
    public const TYPE_GROUP = 'group';

    public static function getTypesFields()
    {
        return [
            self::TYPE_PRIVATE => [
                'name' => trans('telegram.users.' . self::TYPE_PRIVATE),
                'fields' => [
                    'first_name',
                    'last_name',
                    'username',
                    'is_bot',
                    'language_code',
                ]
            ],
            self::TYPE_GROUP => [
                'name' => trans('telegram.users.' . self::TYPE_GROUP),
                'fields' => [
                    'title',
                    'language_code',
                ]
            ],
        ];
    }

    /**
     * @param $name
     * @return $this
     */
    public function setFirstName($name)
    {
        $this->first_name = $name;

        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setLastName($name)
    {
        $this->last_name = $name;

        return $this;
    }

    /**
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return (string)$this->first_name;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return (string)$this->last_name;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return (string)$this->username;
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Command::class);
    }

    public function getLocale()
    {
        return $this->language_code;
    }

    public function setLocale($locale)
    {
        $this->language_code = $locale;

        return $this;
    }

    public function sentMessages()
    {
        return $this->hasMany(SentMessages::class);
    }

    /**
     * @param Builder $query
     * @param string $type
     * @return Builder
     */
    public function scopeByType(Builder $query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * @return bool
     */
    public function isSubscribed()
    {
        return $this->subscription;
    }

    public static function register()
    {
        return new self(
            [

            ]
        );
    }
}
