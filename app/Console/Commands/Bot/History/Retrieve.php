<?php


namespace App\Console\Commands\Bot\History;

use App\Console\Commands\Bot\TelegramTrait;
use Illuminate\Console\Command;

/**
 * Class Retrieve
 *
 * @package App\Console\Commands\Bot\History
 */
class Retrieve extends Command
{
    use TelegramTrait;


    /**
     * @var string
     */
    protected $signature = 'bot:history';

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

        $dialogs = $madeline->get_dialogs();

        foreach ($dialogs as $peer) {
            $madeline->messages->sendMessage(['peer' => $peer, 'message' => 'message']);
        }
    }
}