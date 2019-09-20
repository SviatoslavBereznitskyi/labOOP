<?php

namespace App\Helpers\Telegram;

use App\Models\Subscription;
use App\Services\Telegram\Commands;
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
    public static function networkKeyboard()
    {
        $keyboard = Subscription::getAvailableServices();

        $keyboard = array_chunk($keyboard, 3);

        return Keyboard::make([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false
        ]);
    }

    /**
     * @return Keyboard
     */
    public static function commandsKeyboard($lang, $params = []): Keyboard
    {
        $keyboard = Commands::getCommandsByLang($lang);

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