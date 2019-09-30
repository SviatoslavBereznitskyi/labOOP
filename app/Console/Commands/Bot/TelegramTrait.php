<?php

namespace App\Console\Commands\Bot;

use danog\MadelineProto\API;

/**
 * Class TelegramTrait
 *
 * @package App\Console\Commands\Bot
 */
trait TelegramTrait
{

    /**
     * @return API
     */
    public function getMadelineInstance(): API
    {
        $session = config('telegram.session');

        $sessionPath = $_SERVER['PHP_SELF']=='artisan'?__DIR__ . '/../../../../' . $session:__DIR__.'/../../../../public/'.$session;

       // dd($_SERVER['PHP_SELF']);

        if (file_exists($sessionPath)) {
            $madeline = new API($session);
        } else {
            $madeline = new API($session, config('mdproto'));
        }

        $madeline->serialize(__DIR__ . '/../../../../' . $session);
        $madeline->serialize(__DIR__.'/../../../../public/'.$session);

        return $madeline;
    }
}