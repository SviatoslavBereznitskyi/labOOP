<?php

namespace App\Models;

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

    public static function getAvailableServices()
    {
        return [
            self::TWITTER_SERVICE,
            self::FACEBOOK_SERVICE,
            self::UPWORK_SERVICE,
            self::TELEGRAM_SERVICE,
        ];
    }

    /**
     *
     * @return array|\Illuminate\Contracts\Translation\Translator|string|null
     */
    public static function getMessageAvailableServices()
    {
        $text = trans('answers.input.select_category');

        foreach (self::getAvailableServices() as $key => $item)
        {
            $text = $text . PHP_EOL . ($key+1) . '. ' . $item;
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
}
