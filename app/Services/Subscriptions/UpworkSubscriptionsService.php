<?php


namespace App\Services\Subscriptions;


use App\Models\Subscription;
use Upwork\API\Client;
use Upwork\API\Config;
use Upwork\API\Routers\Jobs\Search;

class UpworkSubscriptionsService extends AbstractSubscriptionsService
{
    /**
     * @return array
     */
    public function getPosts():array
    {
        $client = $this->getUpworkClient(config('upwork.client'));

        $keywords = $this->getKeywords(Subscription::UPWORK_SERVICE, $this->user, $this->frequency);

        $sentMessages = $this->user->sentMessages()
            ->where('service', Subscription::UPWORK_SERVICE)
            ->get();

        $messages = [];

        foreach ($keywords as $keyword) {
            $params = ["q" => $keyword, "title" => "Developer"];
            $jobs = $this->searchUpworkJobs($client, $params);

            foreach ($jobs as $job) {

                if ($sentMessages->where('post_id', $job->id)->first() !== null) {
                    continue;
                }

                $messages[] = [
                    'message_id' => $job->id,
                    'service' => Subscription::UPWORK_SERVICE,
                    'message' => [
                        'chat_id' => $this->user->getKey(),
                        'text' => $keyword . PHP_EOL . ($job->client) . PHP_EOL . $jobs->snippet,
                    ]
                ];
            }
        }

        return $messages;
    }

    private function getUpworkClient(array $config)
    {
        $client = new Client(new Config($config));

        dd($client->getRequestToken());
        $client->auth();

        return $client;
    }

    private function searchUpworkJobs(Client $client, array $params)
    {
        $jobs = new Search($client);
        $jobs->find($params);

        return $jobs->find($params);
    }
}