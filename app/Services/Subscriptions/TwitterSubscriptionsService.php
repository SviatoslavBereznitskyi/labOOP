<?php


namespace App\Services\Subscriptions;


use App\Models\Subscription;
use Carbon\Carbon;
use Twitter;

class TwitterSubscriptionsService extends AbstractSubscriptionsService
{
    /**
     * @var array
     */
    private $lang = ['uk', 'ru', 'en'];

    /**
     * @return array
     */
    public function getPosts():array
    {
        $keywords = $this->getKeywords(Subscription::TWITTER_SERVICE, $this->user, $this->frequency);

        $messages = [];
        $sentMessages = $this->user->sentMessages()
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
                            'chat_id' => $this->user->getKey(),
                            'text' => $keyword . PHP_EOL . ($status->text),
                        ]
                    ];
                }
            }
        }

        return $messages;
    }
}