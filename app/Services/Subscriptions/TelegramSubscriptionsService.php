<?php


namespace App\Services\Subscriptions;


use App\Models\Subscription;
use App\Services\Contracts\TelegramServiceInterface;
use Carbon\Carbon;
use Telegram;

class TelegramSubscriptionsService extends AbstractSubscriptionsService
{
    /**
     * @return array
     * @throws Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function getPosts(): array
    {
        $botId = Telegram::bot()->getMe()->id;

        $keywords = $this->getKeywords(Subscription::TELEGRAM_SERVICE, $this->user, $this->frequency);

        $sentMessages = $this->user->sentMessages()
            ->where('service', Subscription::TELEGRAM_SERVICE)
            ->get();

        $channelsIds = $this->user->channels()->pluck('channels.channel_id')->toArray();


        $messages = [];
        $telegramService = resolve(TelegramServiceInterface::class);
        foreach ($keywords as $keyword) {
            $result = $telegramService->getSearch([
                'q' => $keyword,
                'offset_rate' => 0,
                'offset_id' => 0,
                'limit' => 500,
            ]);

            $searchMessages = $result['messages'];


            $users = $this->transformMessages($result, $botId, $searchMessages, $channelsIds, $sentMessages);

            $messages[$keyword]=[
                'message' => [
                    'chat_id'       => $this->user->getKey(),
                    'text'          => '<b>' . trans('answers.searchForKeyword', ['keyword' => $keyword]) . '</b>',
                    'parse_mode'    => 'HTML',
                ],
            ];

            $isEmpty = true;

            foreach ($users as $tgUser) {
                foreach ($tgUser['messages'] as $message) {
                    $isEmpty = false;
                    $text = $this->getMessageText($message, $tgUser, $users);

                    $messages[] = [
                        'message_id' => $message['id'],
                        'service' => Subscription::TELEGRAM_SERVICE,
                        'message' => [
                            'chat_id' => $this->user->getKey(),
                            'text' => $text,
                        ],

                    ];
                }
            }

            if($isEmpty)
            {
                $messages[$keyword]['message']['text'] = '<b>'.trans('answers.noSearchForKeyword', ['keyword' => $keyword]).'</b>';
            }
        }

        return $messages;
    }

    /**
     * @param array $result
     * @param $botId
     * @param $searchMessages
     * @param $channelIds
     * @return array|mixed
     */
    private function transformMessages(array $result, $botId, $searchMessages, $channelIds, $sentMessages)
    {
        $users = $result['users'];

        $chats = array_filter($result['chats'],function ($chat) use ($channelIds)
        {
            return array_search($chat['id'], $channelIds);
        });

        $users = array_merge($users, $chats);


        array_walk($users, function (&$user) use ($botId, $searchMessages, $sentMessages) {
            $user['messages'] = [];
            if ($botId !== $user['id']) {
                $user['messages'] = array_filter($searchMessages, function ($message) use ($user, $sentMessages) {

                    if ($sentMessages->where('post_id', $message['id'])->first() !== null) {
                        return false;
                    }

                    if ($message['date'] < Carbon::now()->subWeek()->timestamp) {
                        return false;
                    }

                    if (array_key_exists('from_id', $message)) {
                        return $message['from_id'] == $user['id'];
                    } elseif (array_key_exists('to_id', $message)) {
                        return $message['to_id']['channel_id'] == $user['id'];
                    }

                    return false;
                });
            }
        });

        return $users;
    }

    /**
     * @param array $user
     * @return string
     */
    private function parseTgUser(array $user)
    {
        $firstName = key_exists('first_name', $user) ? $user['first_name'] : ' ';
        $username = key_exists('username', $user) ? $user['username'] : ' ';
        $lastName = key_exists('last_name', $user) ? $user['last_name'] : ' ';
        $phone = key_exists('phone', $user) ? $user['phone'] : ' ';
        $title = key_exists('title', $user) ? $user['title'] : ' ';

        return "$firstName $lastName\n@$username\n$phone\n$title";
    }

    private function getMessageText($message, $tgUser, $users)
    {
        $text = $this->parseTgUser($tgUser) . PHP_EOL;

        if (array_key_exists('to_id', $message) && $message['to_id']['_'] == 'peerChannel') {
            $channel = $users[array_search($message['to_id']['channel_id'], array_column($users, 'id'))];
            $text .= $this->parseTgUser($channel) . PHP_EOL;
        }

        $text .= Carbon::createFromTimestamp($message['date'])->toDateTimeString() . PHP_EOL
            . substr($message['message'], 0, 500);

        if (key_exists('entities', $message)) {
            foreach ($message['entities'] as $entity) {
                $url = key_exists('url', $entity) ? $entity['url'] : '';
                $text .= PHP_EOL . $url;
            }
        }

        $text = mb_check_encoding($text, 'UTF-8') ? $text : mb_convert_encoding($text, 'UTF-8');

        return $text;
    }
}