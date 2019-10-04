<?php

namespace App\Events\Channel;

use App\Events\GlobalKeyboardCommandEvent;
use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;

class ChannelEvent extends GlobalKeyboardCommandEvent
{
    public function executeCommand()
    {
        $this->sendMessage(trans('answers.select_category', [], $this->language), KeyboardHelper::networkKeyboard($this->language, Subscription::getGroupServices()));
    }
}
