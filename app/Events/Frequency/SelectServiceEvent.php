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

        $subscription = $this->subscriptionService
            ->getByUserAndService($this->telegramUserId, $this->answer);

        if(null === $subscription){
            $this->lastCommand->delete();
            $this->sendMessage(trans('answers.noSubscription', ['service' => $this->answer], $this->language), KeyboardHelper::commandsKeyboard($this->language));
            return;
        }

        $this->sendMessage(trans('answers.input.frequency', [], $this->language), KeyboardHelper::frequencyKeyboard($this->language));


        $this->commandService->setCommandMessage(get_class($this), $this->lastCommand->getKey(), $subscription);
    }
}
