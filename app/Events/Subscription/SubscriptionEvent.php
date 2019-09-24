<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;

/**
 * Class SubscriptionEvent
 *
 * @package App\Events
 */
class SubscriptionEvent extends GlobalKeyboardCommandEvent
{
    public function executeCommand()
    {
        $this->sendMessage(trans('answers.select_category', [], $this->language), KeyboardHelper::networkKeyboard($this->language));
    }
}