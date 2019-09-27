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

        if (file_exists(__DIR__ . '/../../../../' . $session)) {
            $madeline = new API($session);
        } else {
            $madeline = new API($session, config('mdproto'));
        }

        $madeline->serialize();

        return $madeline;
    }
}