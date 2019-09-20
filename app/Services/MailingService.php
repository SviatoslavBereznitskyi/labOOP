<?php


namespace App\Services;


use App\Models\Subscription;
use App\Models\TelegramUser;
use App\Repositories\Contracts\SentMessagesRepository;
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

    public function __construct(
        TelegramUserRepository $telegramUserRepository,
        SentMessagesRepository $sentMessagesRepository,
        TelegramServiceInterface $telegramService)
    {
        $this->telegramUserRepository = $telegramUserRepository;
        $this->sentMessagesRepository = $sentMessagesRepository;
        $this->telegramService = $telegramService;
    }

    /**
     * @param int $user
     * @return array
     */
    private function getPostTwitter(TelegramUser $user)
    {
        $keywords = $this->getKeywords(Subscription::TWITTER_SERVICE, $user);
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
                        'chat_id' => $user->getKey(),
                        'text' => $keyword . PHP_EOL . utf8_encode($status->text),
                    ];
                    $this->sentMessagesRepository->create([
                        'post_id' => $status->id,
                        'telegram_user_id' => $user->getKey(),
                        'service' => Subscription::TWITTER_SERVICE,
                    ]);
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
    private function getPostTelegram(TelegramUser $user)
    {
        $botId = Telegram::bot()->getMe()->id;

        $keywords = $this->getKeywords(Subscription::TELEGRAM_SERVICE, $user);

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
                        'chat_id' => $user->getKey(),
                        'text' => $this->parseTgUser($tgUser) . PHP_EOL
                            . Carbon::createFromTimestamp($message['date'])->toDateTimeString() . PHP_EOL
                            . substr(utf8_encode($message['message']), 0, 500),
                    ];

                    $this->sentMessagesRepository->create([
                        'post_id' => $message['id'],
                        'telegram_user_id' => $user->getKey(),
                        'service' => Subscription::TELEGRAM_SERVICE,
                    ]);
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
     * @param int $user
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

        // $upwokrPostMessages = [];

        $telegramPostMessages = $this->getPostTelegram($user);
        $twitterPostMessages = $this->getPostTwitter($user);
        //  $facebookPostMessages = $this->getPostFacebook($user);

        $messages = array_merge($telegramPostMessages, $twitterPostMessages);


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