<?php

namespace App\Events\Channel;


use App\Events\AnswerKeyboardCommandEvent;
use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use App\TelegramCommands\InlineCommands;

class ChannelServiceSelectEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $services = Subscription::getGroupServices();

        if (false === $this->checkService($services)) {
            return;
        }

        $this->commandRepository->addCommand($this->lastCommand, $this->answer, 'service');

        $this->sendMessage(trans('answers.selectOption', [], $this->language), KeyboardHelper::actionKeyboard($this->language));

        $this->setCommand();
    }
}
