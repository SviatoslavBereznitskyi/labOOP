<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null first_name
 * @property string|null last_name
 * @property string|null username
 * @property string|null language_code
 */
class TelegramUser extends Model
{
    protected $guarded = [];

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
        return $this->hasOne(Message::class);
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
}
