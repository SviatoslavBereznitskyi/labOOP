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
}