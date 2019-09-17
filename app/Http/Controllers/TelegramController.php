<?php

namespace App\Http\Controllers;

use App;
use App\Models\Message;
use App\Models\TelegramUser;
use App\Repositories\Contracts\MessageRepository;
use App\Repositories\Contracts\TelegramUserRepository;
use App\Services\Contracts\TelegramServiceInterface;
use App\Services\Telegram\Commands;
use App\TelegramCommands\HelpCommand;
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

    public function commands(Request $request, MessageRepository $messageRepository, TelegramServiceInterface $telegramService)
    {
        Telegram::commandsHandler(true);
        $telegram = Telegram::getWebhookUpdates();

        if (!isset($telegram['message'])) {
            return;
        }
        $message = $telegram['message'];

        $telegramService->processMessages($message['message_id'], $message['chat']['id']);

        //$m = Telegram::forwardMessage(['chat_id' => $message['chat']['id'], 'from_chat_id' => $message['chat']['id'], 'message_id' => $message['message_id']]);
        //dd($m);

//        for ($i = $m->message_id - 1; $i > 6434; $i--) {
//            try {
//                $messageForwarded = $telegramService->forwardMessage($i,  403811720 , $message['chat']['id'] );
//
//                Telegram::deleteMessage(['message_id'=>$messageForwarded->id, 'chat_id'=>$messageForwarded->chat->id]);
//                Telegram::forwardMessage(['chat_id' => 403811720, 'from_chat_id' => $message['chat']['id'], 'message_id' => $i]);
//            } catch (Telegram\Bot\Exceptions\TelegramResponseException $exception) {
//                continue;
//            }
//        }
        /** @var TelegramUser $user */
        $chatData = $message['chat'];
        $chatData['language_code'] = isset($message['from']['language_code'])
            ? $message['from']['language_code']
            : App::getLocale();

        $user = $this->telegramService->findOrCreateUser($chatData);

        /** @var Message $lastMessage */
        $lastMessage = $messageRepository->findByUserOrCreate($user->getKey());

        if ($lastMessage->getKeyboardCommand() && !isset($message['entities'])) {

            $eventName = Commands::getAnswersEvents()[$lastMessage->getKeyboardCommand()];

            $answer = 'must be a text';

            if (isset($message['text'])) {
                $answer = $message['text'];
            }
            $parameters = [
                'telegramUserId' => $user->getKey(),
                'answer' => $answer,
                'lastMessage' => $lastMessage,
            ];

            event($telegramService->getEventInstance($eventName, $parameters));

            return;
        }

        if (key_exists('text', $message) && !key_exists('entities', $message)) {
            $keyboardCommand = Commands::findCommandByName($message['text'], $user->getLocale());

            if (!$keyboardCommand) {
                Telegram::sendMessage([
                    'chat_id' => $user->getKey(),
                    'text' => 'not understand']);
                return;
            }

            $command = [
                'keyboard_command' => $keyboardCommand,
            ];

            $messageRepository->update($command, $lastMessage->getKey());

            event($telegramService->getEventInstance($keyboardCommand, ['telegramUserId' => $user->getKey()]));
        }
    }
}
