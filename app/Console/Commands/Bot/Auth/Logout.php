<?php

namespace App\Console\Commands\Bot\Auth;

use App\Console\Commands\Bot\TelegramTrait;
use Illuminate\Console\Command;

/**
 * Class Logout
 *
 * @package App\Console\Commands\Bot\Auth
 */
class Logout extends Command
{
    use TelegramTrait;

    /**
     * @var string
     */
    protected $signature = 'bot:logout';

    /**
     * @var string
     */
    protected $description = 'Telegram logout';


    /**
     * @return void
     */
    public function handle(): void
    {
        $madeline = $this->getMadelineInstance();

        $madeline->logout();
    }
}