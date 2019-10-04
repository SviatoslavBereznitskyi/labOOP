<?php

namespace App\Observers;

use App\Console\Commands\Bot\TelegramTrait;
use App\Models\Channel;

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
    public function updated(Channel $channels)
    {
        //
    }

    /**
     * Handle the channels "deleted" event.
     *
     * @param  \App\Channels  $channels
     * @return void
     */
    public function deleted(Channel $channels)
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
    public function restored(Channel $channels)
    {
        //
    }

    /**
     * Handle the channels "force deleted" event.
     *
     * @param  \App\Channels  $channels
     * @return void
     */
    public function forceDeleted(Channel $channels)
    {
        //
    }
}
