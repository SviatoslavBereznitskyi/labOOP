<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;

/**
 * Class SubscriptionEvent
 *
 * @package App\Events
 */
class SubscriptionEvent extends GlobalKeyboardCommandEvent
{
    public function executeCommand()
    {
        $this->sendMessage(Subscription::getMessageAvailableServices(), KeyboardHelper::networkKeyboard());
    }
}