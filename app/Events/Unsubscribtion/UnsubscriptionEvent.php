<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;

/**
 * Class UnsubscriptionEvent
 *
 * @package App\Events
 */
class UnsubscriptionEvent extends GlobalKeyboardCommandEvent
{

    /**
     * @return void
     */
    public function executeCommand()
    {
        $this->sendMessage(Subscription::getMessageAvailableServices(), KeyboardHelper::networkKeyboard());
    }
}