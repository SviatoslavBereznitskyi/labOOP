<?php


namespace App\Events;

use Telegram;

class SubscriptionEvent extends GlobalKeyboardCommandEvent
{
    public function executeCommand()
    {
        Telegram::sendMessage([
            'chat_id' => $this->telegramUserId,
            'text'=> trans('answers.input.key_words')]);
    }
}