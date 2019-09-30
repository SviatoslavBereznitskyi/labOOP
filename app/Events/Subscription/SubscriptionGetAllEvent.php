<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;

class SubscriptionGetAllEvent extends GlobalKeyboardCommandEvent
{


    public function executeCommand()
    {
        $text = $this->subscriptionService->getUserKeywordsList($this->telegramUserId);

        $this->sendMessage($text, KeyboardHelper::commandsKeyboard($this->language));
    }

}
