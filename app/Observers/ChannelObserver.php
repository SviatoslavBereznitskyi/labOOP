<?php

namespace App\Observers;

use App\Console\Commands\Bot\TelegramTrait;
use App\Models\Channels;

class ChannelObserver
{
    use TelegramTrait;
    /**
     * Handle the channels "created" event.
     *
     * @param Channels $channels
     * @return void
     */
    public function creating(Channels $channels)
    {
        $madeline = $this->getMadelineInstance();

        $madeline->channels->joinChannel(['channel'=>'https://t.me/' . $channels->getUsername()]);

        $channel = $madeline->channels->getChannels(['id' => [ $channels->getUsername()],]);
        $channel = $channel['chats'][0];

        $channels->change([
            'channel_id' => $channel['id'],
            'title' => $channel['title'],
            'username' => $channel['username'],
        ]);
    }

    /**
     * Handle the channels "updated" event.
     *
     * @param  \App\Channels  $channels
     * @return void
     */
    public function updated(Channels $channels)
    {
        //
    }

    /**
     * Handle the channels "deleted" event.
     *
     * @param  \App\Channels  $channels
     * @return void
     */
    public function deleted(Channels $channels)
    {
        $madeline = $this->getMadelineInstance();

        $madeline->channels->leaveChannel(['channel' => $channels->getUsername(), ]);
    }

    /**
     * Handle the channels "restored" event.
     *
     * @param  \App\Channels  $channels
     * @return void
     */
    public function restored(Channels $channels)
    {
        //
    }

    /**
     * Handle the channels "force deleted" event.
     *
     * @param  \App\Channels  $channels
     * @return void
     */
    public function forceDeleted(Channels $channels)
    {
        //
    }
}
