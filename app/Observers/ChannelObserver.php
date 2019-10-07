<?php

namespace App\Observers;

use App\Console\Commands\Bot\TelegramTrait;
use App\Models\Channel;
use App\Models\TelegramUser;
use App\Repositories\Contracts\ChannelRepository;

class ChannelObserver
{
    use TelegramTrait;

    /**
     * Handle the channels "created" event.
     *
     * @param Channel $channels
     * @return void
     */
    public function creating(Channel $channels)
    {
        if ($channels->getService() == Channel::TELEGRAM_SERVICE) {
            $madeline = $this->getMadelineInstance();

            $madeline->channels->joinChannel(['channel' => 'https://t.me/' . $channels->getUsername()]);

            $tgChannel = $madeline->channels->getChannels(['id' => [$channels->getUsername()],]);
            $tgChannel = $tgChannel['chats'][0];


            /** @var ChannelRepository $channelRepository */
            $channelRepository = resolve(ChannelRepository::class);
            $title = $tgChannel['title'];
            $channel = $channelRepository->findByTitle($title, $channels->getService());

            if($channel){
                preg_match("/#\d+/", $channel->getTitle(), $matches);
                $number = 0;
                if(!empty($matches)){
                   $number = str_replace('#','', $matches[0]);
                }

                $title .= '#'. ++$number;
            }

            $channels->change([
                'channel_id' => $tgChannel['id'],
                'title' => $title,
                'username' => $tgChannel['username'],
            ]);
        }
    }

    /**
     * Handle the channels "updated" event.
     *
     * @param \App\Channels $channels
     * @return void
     */
    public function updated(Channel $channels)
    {
        //
    }

    /**
     * Handle the channels "deleted" event.
     *
     * @param \App\Channels $channels
     * @return void
     */
    public function deleted(Channel $channels)
    {
        $madeline = $this->getMadelineInstance();

        $madeline->channels->leaveChannel(['channel' => $channels->getUsername(),]);
    }

    /**
     * Handle the channels "restored" event.
     *
     * @param \App\Channels $channels
     * @return void
     */
    public function restored(Channel $channels)
    {
        //
    }

    /**
     * Handle the channels "force deleted" event.
     *
     * @param \App\Channels $channels
     * @return void
     */
    public function forceDeleted(Channel $channels)
    {
        //
    }
}
