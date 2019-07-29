<?php


namespace App\TelegramCommands;


use App\Models\TelegramUser;
use App\Repositories\Contracts\TelegramUserRepository;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class KeyboardCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'keyboard';

    /**
     * @var string Command Description
     */
    protected $description = 'Help command, Get a list of commands';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $keyboard = [
            ['subscribe', 'unsubscribe'],
        ];


        $this->replyWithChatAction(['action'=> Actions::TYPING]);

        try{
            $userData = Telegram::getWebhookUpdates()['message'];

            /** @var TelegramUserRepository $telegrsmUserREpository */
            $telegrsmUserREpository = resolve(TelegramUserRepository::class);

            /** @var TelegramUser $user */
            $user = $telegrsmUserREpository->find($userData['from']['id']);

            sleep ( 1 );
            $reply_markup = Keyboard::make([
                'keyboard' => $keyboard,
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ]);

            $response = Telegram::sendMessage([
                'chat_id' => $user->getKey(),
                'text' => 'Select options',
                'reply_markup' => $reply_markup
            ]);

            $messageId = $response->getMessageId();
            $this->replyWithMessage(['text'=> $messageId]);
        }catch (\Exception $e){
            $this->replyWithMessage(['text'=> $e->getMessage()]);
        }
    }
}