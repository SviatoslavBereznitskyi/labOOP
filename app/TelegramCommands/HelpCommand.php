<?php

namespace App\TelegramCommands;

use App\Helpers\Telegram\KeyboardHelper;
use App\Repositories\Contracts\TelegramUserRepository;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Class HelpCommand.
 */
class HelpCommand extends AbstractCommand
{

    /**
     * @var string Command Name
     */
    protected $name = 'help';

    /**
     * @var string Command Description
     */
    protected $description = 'answers.help_command';


    /**
     * @return void
     */
    public function handle(): void
    {
        $this->init();
        $commands = $this->telegram->getCommands();

        $language = $this->locale;

        $text = '';
        foreach ($commands as $name => $handler) {
            /* @var Command $handler */
            $text .= sprintf('/%s - %s'.PHP_EOL, $name, trans($handler->getDescription(), [], $language));
        }

        $reply_markup = KeyboardHelper::commandsKeyboard($language);

        $this->replyWithMessage(compact('text', 'reply_markup'));
    }
}
