<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;

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
        $this->sendMessage(trans('answers.select_category', [], $this->language), KeyboardHelper::networkKeyboard( $this->language));
    }
}