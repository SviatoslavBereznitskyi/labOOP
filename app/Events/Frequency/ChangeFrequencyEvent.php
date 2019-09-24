<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;

class ChangeFrequencyEvent extends GlobalKeyboardCommandEvent
{
    public function executeCommand()
    {
        $this->sendMessage(trans('answers.select_category', [], $this->language), KeyboardHelper::networkKeyboard($this->language));
    }
}
