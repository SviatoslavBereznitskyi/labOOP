<?php


namespace App\Events;

use App\Models\Subscription;
use Telegram;

class SubscriptionEvent extends GlobalKeyboardCommandEvent
{
    public function executeCommand()
    {
        Telegram::sendMessage([
            'chat_id' => $this->telegramUserId,
            'text' => Subscription::getMessageAvailableServices(),
        ]);
    }
}