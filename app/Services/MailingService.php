<?php


namespace App\Services;


use App\Models\Subscription;
use App\Models\TelegramUser;
use App\Repositories\Contracts\TelegramUserRepository;
use App\Services\Contracts\MailingServiceInterface;
use Carbon\Carbon;
use Telegram;
use Twitter;

class MailingService implements MailingServiceInterface
{
    /**
     * @var TelegramUserRepository
     */
    private $telegramUserRepository;

    private $lang = ['uk', 'ru', 'en'];

    public function __construct(TelegramUserRepository $telegramUserRepository)
    {
        $this->telegramUserRepository = $telegramUserRepository;
    }

    /**
     * @param int $userId
     * @return array
     */
    private function getPostTwitter(TelegramUser $user)
    {
        $keywords = $this->getKeywords(Subscription::TWITTER_SERVICE, $user);
        $messages = [];

        foreach ($keywords as $keyword) {
            foreach ($this->lang as $lang) {
                $query = [
                    'q' => $keyword . ' lang:' . $lang,
                    'maxResults' => '4',
                    'fromDate' => Carbon::now()->subMinutes(10),
                    'toDate' => Carbon::now(),
                ];
                foreach (Twitter::getSearch($query)->statuses as $status) {
                    $messages[] = [
                        'chat_id' => $user->getKey(),
                        'text' => $status->text,
                    ];
                }
            }
        }

        return $messages;
    }

    /**
     * @param int $userId
     * @return array
     */
    private function getPostUpwork(TelegramUser $user)
    {
        $keywords = $this->getKeywords(Subscription::UPWORK_SERVICE, $user);

        $messages = [];

        return $messages;
    }

    /**
     * @param int $userId
     * @return array
     */
    private function getPostFacebook(TelegramUser $user)
    {
        $keywords = $this->getKeywords(Subscription::FACEBOOK_SERVICE, $user);

        $messages = [];

        return $messages;
    }

    /**
     * @param int $userId
     */
    private function sendMessagesToUser(TelegramUser $user)
    {
        $twitterPostMessages = $this->getPostTwitter($user);
        $upwokrPostMessages = $this->getPostUpwork($user);
        $facebookPostMessages = $this->getPostFacebook($user);

        $messages = array_merge($facebookPostMessages, $twitterPostMessages, $upwokrPostMessages);

        foreach ($messages as $message) {
            Telegram::sendMessage($message);
        }
    }

    private function getKeywords($service, TelegramUser $user)
    {
        /** @var Subscription $subscription */
        $subscription = $user->subscriptions()->where('service', $service)->first();

        if (!$subscription) {
            return [];
        }

        $keywords = $subscription->getKeywords();

        return $keywords;
    }

    public function sendAllSubscription()
    {
        $users = $this->telegramUserRepository->all();

        foreach ($users as $user) {
            $this->sendMessagesToUser($user);
        }
    }
}