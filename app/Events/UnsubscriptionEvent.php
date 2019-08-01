<?php


namespace App\Events;


use Telegram;

class UnsubscriptionEvent extends GlobalKeyboardCommandEvent
{
    public function executeCommand()
    {
        Telegram::sendMessage([
            'chat_id' => $this->telegramUserId,
            'text'=> UnsubscriptionEvent::class]);
    }
}