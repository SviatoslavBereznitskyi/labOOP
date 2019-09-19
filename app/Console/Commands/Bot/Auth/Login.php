<?php

namespace App\Console\Commands\Bot\Auth;

use App\Console\Commands\Bot\TelegramTrait;
use Illuminate\Console\Command;

/**
 * Class Message
 *
 * @package App\Console\Commands\Bot\Auth
 */
class Login extends Command
{
    use TelegramTrait;

    /**
     * @var string
     */
    protected $signature = 'bot:login {token?}';

    /**
     * @var string
     */
    protected $description = 'Login bot';


    /**
     * @return void
     */
    public function handle(): void
    {
        $madeline = $this->getMadelineInstance();

        $token = $this->argument('token');

        if (null === $token) {
            $token = getenv('TELEGRAM_BOT_TOKEN');
            if (null === $token) {
                $token = readline('Token: ');
            }
        }

        $madeline->bot_login($token);
    }
}