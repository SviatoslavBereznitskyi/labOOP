<?php


namespace App\Services\Subscriptions;


use App\Models\TelegramUser;

abstract class AbstractSubscriptionsService
{
    /**
     * @var TelegramUser
     */
    protected $user;
    /**
     * @var int
     */
    protected $frequency;

    public function __construct(TelegramUser $user, $frequency)
    {

        $this->user = $user;
        $this->frequency = $frequency;
    }

    /**
     * @return array
     */
    public abstract function getPosts():array;

    protected function getKeywords($service, TelegramUser $user, $frequency)
    {
        /** @var Subscription $subscription */
        $subscription = $user->subscriptions()->byService($service);

        if ($frequency) {
            $subscription = $subscription->byFrequency($frequency);
        }

        $subscription = $subscription->first();

        if (!$subscription) {
            return [];
        }

        $keywords = $subscription->getKeywords();

        return $keywords;
    }
}