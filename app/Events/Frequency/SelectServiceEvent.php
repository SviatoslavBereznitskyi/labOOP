<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;

class SelectServiceEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $services = Subscription::getAvailableServices();

        if (false === $this->checkService($services)) {
            return;
        }


        $this->sendMessage(trans('answers.input.frequency', [], $this->language), KeyboardHelper::frequencyKeyboard($this->language));

        $subscription = $this->subscriptionService
            ->getByUserAndService($this->telegramUserId, $this->answer);

        $this->commandService->setCommandMessage(get_class($this), $this->lastCommand->getKey(), $subscription);
    }
}
