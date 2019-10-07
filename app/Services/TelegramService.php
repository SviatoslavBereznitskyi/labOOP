<?php


namespace App\Services;


use App;
use App\Console\Commands\Bot\TelegramTrait;
use App\Models\Channel;
use App\Models\TelegramUser;
use App\Repositories\Contracts\TelegramUserRepository;
use App\Services\Contracts\TelegramServiceInterface;
use Telegram;

class TelegramService implements TelegramServiceInterface
{
    use TelegramTrait;
    /**
     * @var TelegramUserRepository
     */
    private $telegramUserRepository;
    /**
     * @var \danog\MadelineProto\API
     */
    private $madeline;

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

        if (!$user) {
            if (null === $parameters['language_code']) {
                $parameters['language_code'] = App::getLocale();
            }
            $this->telegramUserRepository->create($parameters);
            $user = ($this->telegramUserRepository->find($parameters['id']));

            $user->channels()->attach(Channel::all());
            /** @var TelegramUser $user */
            return $user;
        }

        return $user;
    }

    public function getSearch(array $query)
    {
        if (null === $this->madeline) {
            $this->madeline = $this->getMadelineInstance();
        }

        $messages = $this->madeline->messages->searchGlobal($query);
        return $messages;
    }

    public function changeLanguage($userId, $lang)
    {
        /** @var TelegramUser $user */
        $user = $this->telegramUserRepository->findOrFail($userId);

        $user->setLocale($lang)->save();

        return $user;
    }


}