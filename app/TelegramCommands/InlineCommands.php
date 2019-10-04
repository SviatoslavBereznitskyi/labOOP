<?php

namespace App\TelegramCommands;

use App\Events\Channel\ChannelActionSelectEvent;
use App\Events\Channel\ChannelAddEvent;
use App\Events\Channel\ChannelDeleteEvent;
use App\Events\Channel\ChannelEvent;
use App\Events\Channel\ChannelSelectEvent;
use App\Events\Channel\ChannelServiceSelectEvent;
use App\Events\SelectServiceEvent;
use App\Events\ChangeFrequencyEvent;
use App\Events\SetFrequencyEvent;
use App\Events\SubscriptionGetAllEvent;
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
class InlineCommands
{

    /**
     * KeyboardCommands
     */
    const DONE       = 'answers.done';
    const DELETE_ALL = 'answers.delete_all';
    const SELECT_ALL = 'answers.selectAll';
    const CANCEL     = 'answers.cancel';

    const UNSUBSCRIBE_ACTION = 'deleteAction';
    const ADD_ACTION = 'addAction';
    const SUBSCRIBE_ACTION = 'subscribe';

    const SUBSCRIBE_COMMAND             = SubscriptionEvent::class;
    const SUBSCRIPTION_KEYWORDS_EVENT   = SubscriptionKeywordsEvent::class;
    const SUBSCRIBE_ANSWER_EVENT        = SubscriptionSelectServiceEvent::class;
    const SUBSCRIPTIONS_GET_ALL         = SubscriptionGetAllEvent::class;

    const CHANNELS_COMMAND              = ChannelEvent::class;
    const CHANNEL_SERVICE_SELECT        = ChannelServiceSelectEvent::class;
    const CHANNELS_ACTION_SELECT        = ChannelActionSelectEvent::class;
    const CHANNEL_SELECT                = ChannelSelectEvent::class;
    const CHANNEL_ADD                   = ChannelAddEvent::class;
    const CHANNEL_DELETE                = ChannelDeleteEvent::class;

    const UNSUBSCRIBE_COMMAND           = UnsubscriptionEvent::class;
    const UNSUBSCRIBE_ANSWER_EVENT      = UnsubscriptionSelectServiceEvent::class;
    const UNSUBSCRIPTION_KEYWORDS_EVENT = UnsubscriptionKeywordsEvent::class;

    const CHANGE_FREQUENCY_COMMAND      = ChangeFrequencyEvent::class;
    const CHANGE_FREQUENCY_EVENT        = SelectServiceEvent::class;
    const SET_FREQUENCY_EVENT           = SetFrequencyEvent::class;

    public static function getCommandsByLang($lang)
    {
        return [
            self::SUBSCRIBE_COMMAND        => trans('commands.' . self::SUBSCRIBE_COMMAND, [], $lang),
            self::UNSUBSCRIBE_COMMAND      => trans('commands.' . self::UNSUBSCRIBE_COMMAND, [], $lang),
            self::CHANGE_FREQUENCY_COMMAND => trans('commands.' . self::CHANGE_FREQUENCY_COMMAND, [], $lang),
            self::SUBSCRIPTIONS_GET_ALL    => trans('commands.' . self::SUBSCRIPTIONS_GET_ALL, [], $lang),
            self::CHANNELS_COMMAND         => trans('commands.' . self::CHANNELS_COMMAND, [], $lang),
        ];
    }

    public static function getActionsByLang($lang)
    {
        return [
            self::CHANNEL_DELETE           => trans('commands.action.' . self::UNSUBSCRIBE_ACTION, [], $lang),
            self::CHANNEL_ADD              => trans('commands.action.' . self::ADD_ACTION, [], $lang),
            self::CHANNEL_SELECT           => trans('commands.action.' . self::SUBSCRIBE_ACTION, [], $lang),
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

            self::CHANNELS_COMMAND         => self::CHANNEL_SERVICE_SELECT,
            self::CHANNEL_SERVICE_SELECT   => self::CHANNELS_ACTION_SELECT,
            self::CHANNELS_ACTION_SELECT   => [
                self::CHANNEL_DELETE => self::UNSUBSCRIBE_ACTION,
                self::CHANNEL_ADD    => self::ADD_ACTION,
                self::CHANNEL_SELECT => self::SUBSCRIBE_ACTION,
            ],
        ];
    }

    public static function getAnswerEvent($previousEvent, $answer, $locale)
    {
        $eventsList = self::getAnswersEvents();

        if(!array_key_exists($previousEvent, $eventsList)){
           return null;
        }

        $events = $eventsList[$previousEvent];

        $event = is_array($events)?array_search($answer, self::getActionsByLang($locale)):$events;

        return $event;
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

    public static function getChannelsActions()
    {
        return [
            self::SUBSCRIBE_ACTION,
            self::ADD_ACTION,
            self::UNSUBSCRIBE_ACTION,
        ];
    }

    public static function getChannelsActionsTranslated($language)
    {
        $actions = self::getChannelsActions();
        $actionsTranslated = [];

        foreach ($actions as $action) {
            $actionsTranslated[$action] = trans('commands.action.' . $action, [], $language ?? app()->getLocale());
        }

        return $actionsTranslated;
    }
}