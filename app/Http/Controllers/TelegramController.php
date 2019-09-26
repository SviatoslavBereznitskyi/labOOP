<?php

namespace App\Http\Controllers;

use App\Models\InlineCommand;
use App\Models\TelegramUser;
use App\Repositories\Contracts\CommandRepository;
use App\Services\Contracts\TelegramServiceInterface;
use App\TelegramCommands\InlineCommands;
use Illuminate\Http\Request;
use Telegram;

class TelegramController extends Controller
{

    /**
     * @var TelegramServiceInterface
     */
    private $telegramService;

    public function __construct(TelegramServiceInterface $telegramService)
    {

        $this->telegramService = $telegramService;
    }

    public function commands(Request $request, CommandRepository $messageRepository, TelegramServiceInterface $telegramService)
    {
        $telegram = Telegram::getWebhookUpdates();

        if (!isset($telegram['message'])) {
            return;
        }

        $message = $telegram['message'];

        /** @var TelegramUser $telegramUser */
        $chatData = $message['chat'];
        $chatData['language_code'] = isset($message['from']['language_code'])
            ? $message['from']['language_code']
            : null;

        $telegramUser = $this->telegramService->findOrCreateUser($chatData);

        Telegram::commandsHandler(true);

        if(false == $telegramUser->isSubscribed()){
            return;
        }

        /** @var InlineCommand $lastMessage */
        $lastMessage = $messageRepository->findByUserOrCreate($telegramUser->getKey());

        if(isset($message['entities'])){
            $lastMessage->delete();
            return;
        }

        if ($lastMessage->getKeyboardCommand() && !isset($message['entities'])) {

            $eventName = InlineCommands::getAnswersEvents()[$lastMessage->getKeyboardCommand()];

            $answer = 'must be a text';

            if (isset($message['text'])) {
                $answer = $message['text'];
            }

            $parameters = [
                'telegramUser' => $telegramUser,
                'answer' => $answer,
                'lastMessage' => $lastMessage,
            ];

            event($telegramService->getEventInstance($eventName, $parameters));

            return;
        }

        if (key_exists('text', $message) && !key_exists('entities', $message)) {
            $keyboardCommand = InlineCommands::findCommandByName($message['text'], $telegramUser->getLocale());

            if(isset($message['from']['language_code']) && $message['from']['language_code'] != $telegramUser->getLocale()){
                $this->telegramService->changeLanguage($telegramUser->getKey(), $message['from']['language_code']);
            }

            if (!$keyboardCommand) {
                Telegram::sendMessage([
                    'chat_id' => $telegramUser->getKey(),
                    'text' => 'not understand']);
                return;
            }

            $command = [
                'keyboard_command' => $keyboardCommand,
            ];

            $messageRepository->update($command, $lastMessage->getKey());

            event($telegramService->getEventInstance($keyboardCommand, ['telegramUser' => $telegramUser]));
        }
    }
}
