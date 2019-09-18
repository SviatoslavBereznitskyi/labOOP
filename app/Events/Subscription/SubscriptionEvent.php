<?php

namespace App\Events;

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
        $this->sendMessage(Subscription::getMessageAvailableServices());
    }
}