<?php

namespace App\TelegramCommands;

use App\Models\TelegramUser;
use App\Repositories\Contracts\TelegramUserRepository;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Actions;
use Telegram\Bot\Laravel\Facades\Telegram;

class SubscribeCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'subscribe';

    /**
     * @var string Command Description
     */
    protected $description = 'Test command, Get an info about user';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        try {
            $userData = Telegram::getWebhookUpdates()['message'];

            /** @var TelegramUserRepository $telegrsmUserREpository */
            $telegrsmUserREpository = resolve(TelegramUserRepository::class);

            /** @var TelegramUser $user */
            $user = $telegrsmUserREpository->find($userData['from']['id']);

            $text = sprintf('%s %s', $user->getFirstName(), $user->getLastName());
            sleep(1);
            $this->replyWithMessage(['text' => $text]);
        } catch (\Exception $e) {
            $this->replyWithMessage(['text' => $e->getMessage()]);
        }
    }
}