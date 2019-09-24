<?php


namespace App\Services;


use App\Models\Subscription;
use App\Models\TelegramUser;
use App\Repositories\Contracts\SentMessagesRepository;
use App\Repositories\Contracts\SubscriptionRepository;
use App\Repositories\Contracts\TelegramUserRepository;
use App\Services\Contracts\MailingServiceInterface;
use App\Services\Contracts\TelegramServiceInterface;
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

    /**
     * @param int $user
     * @return array
     */
    private function getPostTwitter(TelegramUser $user, $frequency)
    {
        $keywords = $this->getKeywords(Subscription::TWITTER_SERVICE, $user, $frequency);

        $messages = [];
        $sentMessages = $user->sentMessages()
            ->where('service', Subscription::TWITTER_SERVICE)
            ->get();
        foreach ($keywords as $keyword) {
            foreach ($this->lang as $lang) {
                $query = [
                    'q' => $keyword . ' lang:' . $lang,
                    'maxResults' => '5',
                    'fromDate' => Carbon::now()->subMinutes(350),
                    'toDate' => Carbon::now(),
                ];

                $twits = Twitter::getSearch($query);

                foreach ($twits->statuses as $status) {
                    if ($sentMessages->where('post_id', $status->id)->first() !== null) {
                        continue;
                    }
                    $messages[] = [
                        'message_id' => $status->id,
                        'service' => Subscription::TWITTER_SERVICE,
                        'message' => [
                            'chat_id' => $user->getKey(),
                            'text' => $keyword . PHP_EOL . ($status->text),
                        ]
                    ];
                }
            }
        }

        return $messages;
    }

    /**
     * @param int $user
     * @return array
     */
    private function getPostUpwork(TelegramUser $user)
    {
        $keywords = $this->getKeywords(Subscription::UPWORK_SERVICE, $user);
        $sentMessages = $user->sentMessages()
            ->where('service', Subscription::UPWORK_SERVICE)
            ->get();

        $config = config('upwork');

        $client = new \Upwork\API\Client($config);

        $jobs = new \Upwork\API\Routers\Jobs\Search($client);

        foreach ($keywords as $keyword) {
            $params = ["q" => $keyword, "title" => "Developer"];
            $jobs->find($params);
        }


        $messages = [];

        return $messages;
    }


    /**
     * @param int $user
     * @return array
     */
    private function getPostTelegram(TelegramUser $user, $frequency)
    {
        $botId = Telegram::bot()->getMe()->id;

        $keywords = $this->getKeywords(Subscription::TELEGRAM_SERVICE, $user, $frequency);

        $sentMessages = $user->sentMessages()
            ->where('service', Subscription::TELEGRAM_SERVICE)
            ->get();

        $messages = [];

        foreach ($keywords as $keyword) {
            $result = $this->telegramService->getSearch([
                'q' => $keyword,
                'offset_rate' => 0,
                'offset_id' => 0,
                'limit' => 99,
            ]);

            $searchMessages = $result['messages'];
            $users = $result['users'];

            $this->transformMessages($users, $botId, $searchMessages);

            foreach ($users as $tgUser) {
                foreach ($tgUser['messages'] as $message) {
                    if ($sentMessages->where('post_id', $message['id'])->first() !== null) {
                        continue;
                    }

                    $messages[] = [
                        'message_id' => $message['id'],
                        'service' => Subscription::TELEGRAM_SERVICE,
                        'message' => [
                            'chat_id' => $user->getKey(),
                            'text' => $this->parseTgUser($tgUser) . PHP_EOL
                                . Carbon::createFromTimestamp($message['date'])->toDateTimeString() . PHP_EOL
                                . substr($message['message'], 0, 500),
                        ],

                    ];
                }
            }
        }

        return $messages;
    }

    /**
     * @param array $users
     * @param $botId
     * @param $searchMessages
     */
    private function transformMessages(array &$users, $botId, $searchMessages)
    {
        array_walk($users, function (&$user) use ($botId, $searchMessages) {

            $user['messages'] = [];
            if ($botId !== $user['id']) {
                $user['messages'] = array_filter($searchMessages, function ($message) use ($user) {
                    //  dump($message);
                    if (array_key_exists('from_id', $message)) {
                        return $message['from_id'] == $user['id'];
                    }
                    return false;
                });
            }
        });
    }

    private function parseTgUser(array $user)
    {
        $firstName = key_exists('first_name', $user) ? $user['first_name'] : ' ';
        $username = key_exists('username', $user) ? $user['username'] : ' ';
        $lastName = key_exists('last_name', $user) ? $user['last_name'] : ' ';
        $phone = key_exists('phone', $user) ? $user['phone'] : ' ';

        return "$firstName $lastName\n@$username\n$phone";
    }

    /**
     * @param TelegramUser $user
     * @param $frequency
     * @return array
     */
    private function getPostFacebook(TelegramUser $user, $frequency)
    {
        $keywords = $this->getKeywords(Subscription::FACEBOOK_SERVICE, $user, $frequency);

        $messages = [];

        return $messages;
    }

    /**
     * @param int $userId
     */
    private function sendMessagesToUser(TelegramUser $user, $frequency)
    {
        $telegramPostMessages = $this->getPostTelegram($user, $frequency);
        $twitterPostMessages = $this->getPostTwitter($user, $frequency);

        $messages = array_merge($telegramPostMessages, $twitterPostMessages);

        foreach ($messages as $key => $message) {

            $this->sentMessagesRepository->create([
                'post_id' => $message['message_id'],
                'telegram_user_id' => $user->getKey(),
                'service' => $message['service'],
            ]);

            Telegram::sendMessage($message['message']);
        }
    }

    private function getKeywords($service, TelegramUser $user, $frequency)
    {
        /** @var Subscription $subscription */
        $subscription = $user->subscriptions()->byService($service);

        if ($frequency) {
            $subscription = $subscription->byFrequency($frequency);
        }

        $subscription = $subscription->first();

        if (!$subscription) {
            return [];
        }

        $keywords = $subscription->getKeywords();

        return $keywords;
    }

    public function sendSubscription($frequency)
    {

        $users = $this->telegramUserRepository->all();

        foreach ($users as $user) {
            $this->sendMessagesToUser($user, $frequency);
        }
    }
}