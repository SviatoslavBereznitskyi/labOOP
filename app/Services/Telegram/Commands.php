<?php


namespace App\Services\Telegram;


use App\Events\ChangeFrequencyAnswerEvent;
use App\Events\ChangeFrequencyEvent;
use App\Events\SetFrequencyEvent;
use App\Events\SubscriptionAnswerEvent;
use App\Events\SubscriptionEvent;
use App\Events\SubscriptionKeywordsEvent;
use App\Events\UnsubscriptionAnswerEvent;
use App\Events\UnsubscriptionEvent;
use App\Events\UnsubscriptionKeywordsEvent;

class Commands
{
    const SUBSCRIBE_COMMAND             = SubscriptionEvent::class;
    const UNSUBSCRIBE_COMMAND           = UnsubscriptionEvent::class;
    const SUBSCRIBE_ANSWER_EVENT        = SubscriptionAnswerEvent::class;
    const UNSUBSCRIBE_ANSWER_EVENT      = UnsubscriptionAnswerEvent::class;
    const SUBSCRIPTION_KEYWORDS_EVENT   = SubscriptionKeywordsEvent::class;
    const CHANGE_FREQUENCY_COMMAND      = ChangeFrequencyEvent::class;
    const CHANGE_FREQUENCY_EVENT        = ChangeFrequencyAnswerEvent::class;
    const SET_FREQUENCY_EVENT           = SetFrequencyEvent::class;
    const UNSUBSCRIPTION_KEYWORDS_EVENT = UnsubscriptionKeywordsEvent::class;

    public static function getKeyboardCommandsByLang($lang)
    {
        return [
            self::SUBSCRIBE_COMMAND => trans('commands.' . self::SUBSCRIBE_COMMAND, [], $lang ),
            self::UNSUBSCRIBE_COMMAND => trans('commands.' . self::UNSUBSCRIBE_COMMAND, [], $lang ),
            self::CHANGE_FREQUENCY_COMMAND => trans('commands.' . self::CHANGE_FREQUENCY_COMMAND, [], $lang ),
        ];
    }

    public static function getAnswersEvents()
    {
        return [
            self::SUBSCRIBE_COMMAND => self::SUBSCRIBE_ANSWER_EVENT,
            self::UNSUBSCRIBE_COMMAND => self::UNSUBSCRIBE_ANSWER_EVENT,
            self::UNSUBSCRIBE_ANSWER_EVENT => self::UNSUBSCRIPTION_KEYWORDS_EVENT,
            self::SUBSCRIBE_ANSWER_EVENT => self::SUBSCRIPTION_KEYWORDS_EVENT,
            self::CHANGE_FREQUENCY_COMMAND => self::CHANGE_FREQUENCY_EVENT,
            self::CHANGE_FREQUENCY_EVENT => self::SET_FREQUENCY_EVENT,
        ];
    }

    /**
     * @param $name
     * @param string $locale
     * @return false|int|string
     */
    public static function findCommandByName($name, $locale = 'en')
    {
        $commands = self::getKeyboardCommandsByLang($locale);

        return array_search($name, $commands);
    }
}