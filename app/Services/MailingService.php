<?php


namespace App\Services;


use App\Models\Subscription;
use App\Models\TelegramUser;
use App\Repositories\Contracts\SentMessagesRepository;
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
    /**
     * @var SentMessagesRepository
     */
    private $sentMessagesRepository;

    public function __construct(TelegramUserRepository $telegramUserRepository, SentMessagesRepository $sentMessagesRepository)
    {
        $this->telegramUserRepository = $telegramUserRepository;
        $this->sentMessagesRepository = $sentMessagesRepository;
    }

    /**
     * @param int $userId
     * @return array
     */
    private function getPostTwitter(TelegramUser $user)
    {
        $keywords = $this->getKeywords(Subscription::TWITTER_SERVICE, $user);
        $messages = [];
        $sentMessages = $user->sentMessages()
            ->where('service', Subscription::TWITTER_SERVICE)
            ->whereDate('created_at', Carbon::now())
            ->get();
        foreach ($keywords as $keyword) {
            foreach ($this->lang as $lang) {
                $query = [
                    'q' => $keyword . ' lang:' . $lang,
                    'maxResults' => '3',
                    'fromDate' => Carbon::now()->subMinutes(10),
                    'toDate' => Carbon::now(),
                ];

                $twits = Twitter::getSearch($query);

                foreach ($twits->statuses as $status) {
                    if( $sentMessages->where('post_id', $status->id)->first() !== null){

                        continue;
                    }
                    $messages[] = [
                        'chat_id' => $user->getKey(),
                        'text' => $status->text,
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
     * @param int $userId
     * @return array
     */
    private function getPostUpwork(TelegramUser $user)
    {
        $keywords = $this->getKeywords(Subscription::UPWORK_SERVICE, $user);
        $sentMessages = $user->sentMessages()
            ->where('service', Subscription::UPWORK_SERVICE)
            ->where('created_at', Carbon::now())
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

        $upwokrPostMessages=[];
        $twitterPostMessages = $this->getPostTwitter($user);
       //$upwokrPostMessages = $this->getPostUpwork($user);
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