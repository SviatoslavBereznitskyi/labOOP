<?php


namespace App\Services;


use App\Models\TelegramUser;
use App\Repositories\Contracts\TelegramUserRepository;
use App\Services\Contracts\TelegramServiceInterface;
use Telegram;

class TelegramService implements TelegramServiceInterface
{
    /**
     * @var TelegramUserRepository
     */
    private $telegramUserRepository;

    public function __construct(TelegramUserRepository $telegramUserRepository)
    {
        $this->telegramUserRepository = $telegramUserRepository;
    }

    public function getEventInstance($name, array $parameters = [])
    {
        return resolve($name, $parameters);
    }

    /**
     * @param array $parameters
     * @return TelegramUser|mixed
     */
    public function findOrCreateUser(array $parameters = [])
    {
        /** @var TelegramUser $user */
        $user = $this->telegramUserRepository->find($parameters['id']);

        if(!$user){
            $this->telegramUserRepository->create($parameters);
            /** @var TelegramUser $user */
            return $this->telegramUserRepository->find($parameters['id']);
        }

        isset($parameters['language_code'])
            ? $user->setLocale($parameters['language_code'])->save()
            : 0;

        return $user;
    }

    /**
     * @param $messageId
     * @param $chatId
     */
    public function processMessages($messageId, $chatId)
    {
        $m =$this->getMessage($messageId, $chatId, 403811720);
    }

    protected function getMessage($messageId, $fromChatId, $userId)
    {
        $message = Telegram::forwardMessage([
            'chat_id' => $userId,
            'from_chat_id' => $fromChatId,
            'message_id' => $messageId
        ]);

        Telegram::deleteMessage([
            'chat_id'=>$userId,
            'message_id'=>$message->message_id,
        ]);

        return $message;
    }

    public function forwardMessage($messageId, $fromChatId, $userId)
    {
        return Telegram::forwardMessage(['chat_id' => $userId, 'from_chat_id' => $fromChatId, 'message_id' => $messageId]);
    }
}