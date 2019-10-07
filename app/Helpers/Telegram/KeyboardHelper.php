<?php

namespace App\Helpers\Telegram;

use App;
use App\Models\Subscription;
use App\TelegramCommands\InlineCommands;
use Telegram\Bot\Keyboard\Keyboard;

/**
 * Class KeyboardHelper
 *
 * @package App\Helpers\Telegram
 */
class KeyboardHelper
{

    /**
     * @return Keyboard
     */
    public static function networkKeyboard($lang = null, $services = null)
    {
        if (null === $services) {
            $keyboard = Subscription::getAvailableServices();
            array_push($keyboard, trans(InlineCommands::CANCEL, [], $lang ?? App::getLocale()));
        } else {
            $keyboard = $services;
        }

        $keyboard = array_chunk($keyboard, 3);

        return Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
    }

    /**
     * @return Keyboard
     */
    public static function commandsKeyboard($lang = null, $params = []): Keyboard
    {
        $language = $lang ?? App::getLocale();
        $keyboard = InlineCommands::getCommandsByLang($language);

        $keyboard = array_chunk($keyboard, 3);

        $resizeKeyboard = $params['resize_keyboard'] ?? true;
        $oneTimeKeyboard = $params['one_time_keyboard'] ?? true;

        return Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => $resizeKeyboard,
            'one_time_keyboard' => $oneTimeKeyboard,
        ]);
    }

    /**
     * @param $items
     *
     * @return Keyboard
     */
    public static function itemKeyboard($items, $language): Keyboard
    {
        $keyboard = $items;
        $keyboard = array_chunk($keyboard, 5);
        $keyboard[] = [
            trans(InlineCommands::DELETE_ALL, [], $language),
            trans(InlineCommands::DONE, [], $language),
        ];

        return Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false,
        ]);
    }

    public static function channelsKeyboard($items, $language, $command): Keyboard
    {
        if ($command == trans('commands.action.' . InlineCommands::ADD_ACTION, [], $language)) {
            $keyboard[] = [trans(InlineCommands::CANCEL, [], $language),];
        } else {
            $keyboard = $items;

            $keyboard = array_chunk($keyboard, 3);
            if ($command == trans('commands.action.' . InlineCommands::SUBSCRIBE_ACTION, [], $language)) {

                $keyboard[] = [
                    trans(InlineCommands::SELECT_ALL, [], $language),
                    trans(InlineCommands::CANCEL, [], $language),
                ];
            } else {
                $keyboard[] = [
                    trans(InlineCommands::DELETE_ALL, [], $language),
                    trans(InlineCommands::CANCEL, [], $language),
                ];
            }
        }

        return Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false,
        ]);
    }


    /**
     * @return Keyboard
     */
    public static function numberKeyboard(): Keyboard
    {
        $keyboard = [
            ['7', '8', '9'],
            ['✅4', '✅5', '6'],
            ['1', '2', '3'],
            ['0']
        ];

        return Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public static function frequencyKeyboard($language = null)
    {
        $keyboard = Subscription::getAvailableFrequenciesForHuman($language);
        $keyboard = array_chunk($keyboard, 3);

        array_push($keyboard, [trans(InlineCommands::CANCEL, [], $language ?? app()->getLocale())]);

        return Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    public static function actionKeyboard($language = null)
    {
        $keyboard = InlineCommands::getChannelsActionsTranslated($language);
        $keyboard = array_chunk($keyboard, 3);

        array_push($keyboard, [trans(InlineCommands::CANCEL, [], $language ?? app()->getLocale())]);

        return Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }
}