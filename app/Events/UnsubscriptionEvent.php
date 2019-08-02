<?php


namespace App\Events;


use App\Models\Subscription;
use Telegram;

class UnsubscriptionEvent extends GlobalKeyboardCommandEvent
{
    public function executeCommand()
    {
        Telegram::sendMessage([
            'chat_id' => $this->telegramUserId,
            'text' => Subscription::getMessageAvailableServices(),
        ]);
    }
}