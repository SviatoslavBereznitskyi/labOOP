<?php

namespace App\TelegramCommands;

use App\Helpers\Telegram\KeyboardHelper;
use App\Models\TelegramUser;
use App\Repositories\Contracts\TelegramUserRepository;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Class KeyboardCommand
 *
 * @package App\TelegramCommands
 */
class KeyboardCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'keyboard';

    /**
     * @var string Command Description
     */
    protected $description = 'Show keyboard';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->replyWithChatAction(['action'=> Actions::TYPING]);

        try{
            $userData = Telegram::getWebhookUpdates()['message'];

            /** @var TelegramUserRepository $telegramUserRepository */
            $telegramUserRepository = resolve(TelegramUserRepository::class);

            /** @var TelegramUser $user */
            $user = $telegramUserRepository->find($userData['chat']['id']);

            $reply_markup = KeyboardHelper::commandsKeyboard(
                $user->getLocale(),
                [
                    'resize_keyboard' => true,
                    'one_time_keyboard' => true
                ]
            );

            $response = Telegram::sendMessage([
                'chat_id' => $user->getKey(),
                'text' => 'Select options',
                'reply_markup' => $reply_markup
            ]);

        }catch (\Exception $e){
            $this->replyWithMessage(['text'=> $e->getMessage()]);
        }
    }
}