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
    protected $signature = 'bot:login {--P|phone=} {token?}';

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

        $phone = $this->option('phone');
        $token = $this->argument('token');

        if (null !== $phone) {
            $this->userLogin($madeline, $phone);
        } else {
            $this->botLogin($madeline, $token);
        }
    }

    protected function botLogin($madeline, $token)
    {
        if (null === $token) {
            $token = getenv('TELEGRAM_BOT_TOKEN');
            if (null === $token) {
                $token = readline('Token: ');
            }
        }

        $madeline->bot_login($token);
    }

    protected function userLogin($madeline, $phone)
    {
        $madeline->phone_login($phone);

        $code = readline('Enter the code: ');

        $madeline->complete_phone_login($code);
    }
}