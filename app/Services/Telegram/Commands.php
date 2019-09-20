<?php

namespace App\Services\Telegram;

use App\Events\ChangeFrequencyAnswerEvent;
use App\Events\ChangeFrequencyEvent;
use App\Events\SetFrequencyEvent;
use App\Events\SubscriptionSelectServiceEvent;
use App\Events\SubscriptionEvent;
use App\Events\SubscriptionKeywordsEvent;
use App\Events\UnsubscriptionSelectServiceEvent;
use App\Events\UnsubscriptionEvent;
use App\Events\UnsubscriptionKeywordsEvent;

/**
 * Class Commands
 *
 * @package App\Services\Telegram
 */
class Commands
{

    /**
     * KeyboardCommands
     */
    const DONE       = 'answers.done';
    const DELETE_ALL = 'answers.delete_all';


    const SUBSCRIBE_COMMAND             = SubscriptionEvent::class;
    const SUBSCRIPTION_KEYWORDS_EVENT   = SubscriptionKeywordsEvent::class;
    const SUBSCRIBE_ANSWER_EVENT        = SubscriptionSelectServiceEvent::class;

    const UNSUBSCRIBE_COMMAND           = UnsubscriptionEvent::class;
    const UNSUBSCRIBE_ANSWER_EVENT      = UnsubscriptionSelectServiceEvent::class;
    const UNSUBSCRIPTION_KEYWORDS_EVENT = UnsubscriptionKeywordsEvent::class;

    const CHANGE_FREQUENCY_COMMAND      = ChangeFrequencyEvent::class;
    const CHANGE_FREQUENCY_EVENT        = ChangeFrequencyAnswerEvent::class;
    const SET_FREQUENCY_EVENT           = SetFrequencyEvent::class;

    public static function getCommandsByLang($lang)
    {
        return [
            self::SUBSCRIBE_COMMAND        => trans('commands.' . self::SUBSCRIBE_COMMAND, [], $lang ),
            self::UNSUBSCRIBE_COMMAND      => trans('commands.' . self::UNSUBSCRIBE_COMMAND, [], $lang ),
            self::CHANGE_FREQUENCY_COMMAND => trans('commands.' . self::CHANGE_FREQUENCY_COMMAND, [], $lang ),
        ];
    }

    public static function getAnswersEvents()
    {
        return [
            self::SUBSCRIBE_COMMAND        => self::SUBSCRIBE_ANSWER_EVENT,
            self::SUBSCRIBE_ANSWER_EVENT   => self::SUBSCRIPTION_KEYWORDS_EVENT,

            self::UNSUBSCRIBE_COMMAND      => self::UNSUBSCRIBE_ANSWER_EVENT,
            self::UNSUBSCRIBE_ANSWER_EVENT => self::UNSUBSCRIPTION_KEYWORDS_EVENT,

            self::CHANGE_FREQUENCY_COMMAND => self::CHANGE_FREQUENCY_EVENT,
            self::CHANGE_FREQUENCY_EVENT   => self::SET_FREQUENCY_EVENT,
        ];
    }

    /**
     * @param $name
     * @param string $locale
     * @return false|int|string
     */
    public static function findCommandByName($name, $locale = 'en')
    {
        $commands = self::getCommandsByLang($locale);

        return array_search($name, $commands);
    }
}