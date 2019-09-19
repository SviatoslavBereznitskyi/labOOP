<?php

namespace App\Events;

use App\Models\Subscription;

/**
 * Class UnsubscriptionEvent
 *
 * @package App\Events
 */
class UnsubscriptionEvent extends GlobalKeyboardCommandEvent
{
    public function executeCommand()
    {
        $this->sendMessage(Subscription::getMessageAvailableServices());
    }
}