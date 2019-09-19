<?php

namespace App\Console\Commands\Bot\Message;

use App\Console\Commands\Bot\TelegramTrait;
use Illuminate\Console\Command;


/**
 * Class Message
 *
 * @package App\Console\Commands
 */
class Send extends Command
{
    use TelegramTrait;

    /**
     * @var string
     */
    protected $signature = 'bot:send {peer?} {message?}';

    /**
     * @var string
     */
    protected $description = 'Send message';


    /**
     * @return void
     */
    public function handle(): void
    {
        $madeline = $this->getMadelineInstance();

        $peer = $this->argument('peer');
        if (null === $peer) {
            $peer = '@'.readline('Peer: ');
        }

        $message = $this->argument('message');
        if (null === $message) {
            $message = readline('Message: ');
        }

        $madeline->messages->sendMessage(['peer' => $peer, 'message' => $message]);
    }
}