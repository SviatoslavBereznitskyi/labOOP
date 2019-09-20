<?php

namespace App\Helpers\Telegram;

use App\Models\Subscription;
use App\Services\Telegram\Commands;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

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
    public static function networkKeyboard($services = null)
    {
        if (null === $services) {
            $keyboard = Subscription::getAvailableServices();
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
        $language = Telegram::getWebhookUpdates()['message']['from']['language_code'];
        $keyboard = Commands::getCommandsByLang($language);

        $keyboard = array_chunk($keyboard, 3);

        $resizeKeyboard  = $params['resize_keyboard'] ?? true;
        $oneTimeKeyboard = $params['one_time_keyboard'] ?? true;

        return Keyboard::make([
            'keyboard'          => $keyboard,
            'resize_keyboard'   => $resizeKeyboard,
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
        $keyboard   = $items;
        $keyboard   = array_chunk($keyboard, 5);
        $keyboard[] = [
            trans(Commands::DELETE_ALL, [], $language),
            trans(Commands::DONE, [], $language),
        ];

        return Keyboard::make([
            'keyboard'          => $keyboard,
            'resize_keyboard'   => true,
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
}