<?php


namespace App\TelegramCommands;


use App\Repositories\Contracts\TelegramUserRepository;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Commands\Command;

abstract class AbstractCommand extends Command
{
    /**
     * @var TelegramUserRepository
     */
    protected $telegramUserRepository;

    protected $locale;
    protected $user;

    public function init()
    {
        $this->telegramUserRepository = resolve(TelegramUserRepository::class);

        $this->user = $this->telegramUserRepository->find(Telegram::getWebhookUpdates()['message']['chat']['id']);

        $this->locale = $this->user->getLocale();
    }
}