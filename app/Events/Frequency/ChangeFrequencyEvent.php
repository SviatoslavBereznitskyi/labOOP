<?php

namespace App\Events;

use App\Models\Subscription;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Telegram;

class ChangeFrequencyEvent extends GlobalKeyboardCommandEvent
{
    public function executeCommand()
    {
        Telegram::sendMessage([
            'chat_id' => $this->telegramUserId,
            'text' => Subscription::getMessageAvailableServices(),
        ]);
    }
}
