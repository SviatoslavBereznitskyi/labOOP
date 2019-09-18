<?php

namespace App\Helpers\Telegram;

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
    public static function numberKeyboard()
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