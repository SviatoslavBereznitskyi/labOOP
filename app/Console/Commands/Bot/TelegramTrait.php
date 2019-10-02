<?php

namespace App\Console\Commands\Bot;

use danog\MadelineProto\API;
use Illuminate\Support\Facades\Storage;

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

        $sessionPath = Storage::path($session);

        if (file_exists($sessionPath)) {
            $madeline = new API($sessionPath);
        } else {
            $madeline = new API($sessionPath, config('mdproto'));
        }

        $madeline->serialize($sessionPath);

        return $madeline;
    }
}