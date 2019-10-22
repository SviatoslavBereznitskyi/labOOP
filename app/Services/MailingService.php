<?php


namespace App\Services;


use App\Models\Subscription;
use App\Models\TelegramUser;
use App\Repositories\Contracts\SentMessagesRepository;
use App\Repositories\Contracts\SubscriptionRepository;
use App\Repositories\Contracts\TelegramUserRepository;
use App\Services\Contracts\MailingServiceInterface;
use App\Services\Contracts\TelegramServiceInterface;
use App\Services\Subscriptions\AbstractSubscriptionsService;
use Carbon\Carbon;
use Telegram;
use Twitter;

class MailingService implements MailingServiceInterface
{
    /**
     * @var TelegramUserRepository
     */
    private $telegramUserRepository;

    /**
     * @var SentMessagesRepository
     */
    private $sentMessagesRepository;
    /**
     * @var TelegramServiceInterface
     */
    private $telegramService;
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    public function __construct(
        TelegramUserRepository $telegramUserRepository,
        SubscriptionRepository $subscriptionRepository,
        SentMessagesRepository $sentMessagesRepository,
        TelegramServiceInterface $telegramService)
    {
        $this->telegramUserRepository = $telegramUserRepository;
        $this->sentMessagesRepository = $sentMessagesRepository;
        $this->telegramService = $telegramService;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function sendSubscription($frequency = null)
    {
        $users = $this->telegramUserRepository->getActiveUsers();

        foreach ($users as $user) {
            $this->sendMessagesToUser($user, $frequency);
        }
    }

    /**
     * @param int $userId
     */
    private function sendMessagesToUser(TelegramUser $user, $frequency)
    {
        $services = Subscription::getServiceInstances($user, $frequency);
        foreach ($services as $service){
            $this->sendFromService($service, $user);
        }
    }

    private function sendFromService(AbstractSubscriptionsService $service, TelegramUser $user)
    {
        $messages = $service->getPosts();
        foreach ($messages as $key => $message) {

            if(isset($message['message_id'])){
                $this->sentMessagesRepository->create([
                    'post_id' => $message['message_id'],
                    'telegram_user_id' => $user->getKey(),
                    'service' => $message['service'],
                ]);
            }


            Telegram::sendMessage($message['message']);
        }
    }
}