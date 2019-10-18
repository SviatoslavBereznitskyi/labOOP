<?php

namespace App\Models;

use App\Services\Subscriptions\TelegramSubscriptionsService;
use App\Services\Subscriptions\TwitterSubscriptionsService;
use App\Services\Subscriptions\UpworkSubscriptionsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Subscription.
 * @property array keywords
 * @package namespace App\Models;
 */
class Subscription extends Model implements Transformable
{
    use TransformableTrait;

    const TWITTER_SERVICE  = 'Twitter';
    const FACEBOOK_SERVICE = 'Facebook';
    const UPWORK_SERVICE   = 'UpWork';
    const TELEGRAM_SERVICE = 'Telegram';

    protected $guarded = [];

    protected $casts = [
        'keywords' => 'array'
    ];

    /**
     * return array with names of services
     * @return array
     */
    public static function getAvailableServices()
    {
        return [
            self::TWITTER_SERVICE,
//            self::FACEBOOK_SERVICE,
//            self::UPWORK_SERVICE,
            self::TELEGRAM_SERVICE,
        ];
    }

    public static function getGroupServices()
    {
        return [
            self::TELEGRAM_SERVICE,
        ];
    }

    /**
     * return array of instances subscription services
     * @param TelegramUser $user
     * @param int $frequency
     * @return array
     */
    public static function getServiceInstances(TelegramUser $user, $frequency)
    {
        return [
            new TelegramSubscriptionsService($user, $frequency),
            new TwitterSubscriptionsService($user, $frequency),
          //  new UpworkSubscriptionsService($user, $frequency),
        ];
    }

    protected static function getAvailableFrequencies()
    {
        return [
            '15',
            '30',
            '45',
            '60',
            '120',
            '180',
        ];
    }

    public static function getAvailableFrequenciesForHuman($lang)
    {
        $frequencies = self::getAvailableFrequencies();
        $frequenciesForHuman = [];

        foreach ($frequencies as $frequency) {
            $frequenciesForHuman[$frequency] = trans('answers.frequencyForHuman', ['value' => $frequency], $lang ?? app()->getLocale());
        }

        return $frequenciesForHuman;
    }

    /**
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public static function getMessageAvailableServices()
    {
        $text = trans('answers.input.select_category');

        foreach (self::getAvailableServices() as $key => $item) {
            $text = $text . PHP_EOL . ($key + 1) . '. ' . $item;
        }

        return $text;
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function telegramUser()
    {
        return $this->belongsTo(TelegramUser::class);
    }

    /**
     * @param Builder $query
     * @param int $userId
     * @return Builder
     */
    public function scopeByUser(Builder $query, int $userId)
    {
        return $query->where('telegram_user_id', $userId);
    }

    /**
     * @param Builder $query
     * @param string $service
     * @return Builder
     */
    public function scopeByService(Builder $query, string $service)
    {
        return $query->where('service', $service);
    }

    public function getKeywords()
    {
        return (array)$this->keywords;
    }

    public function scopeByFrequency(Builder $query, string $frequency)
    {
        return $query->where('frequency', $frequency);
    }

    public function getService()
    {
        return $this->service;
    }

    public function getFrequency()
    {
        return $this->frequency;
    }
}
