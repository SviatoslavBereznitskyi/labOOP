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

        $subscription = $this->subscriptionService
            ->getByUserAndService($this->telegramUserId, $this->answer);

        if(null === $subscription){
            $this->lastCommand->delete();
            $this->sendMessage(trans('answers.noSubscription', ['service' => $this->answer], $this->language), KeyboardHelper::commandsKeyboard($this->language));
            return;
        }

        $this->commandRepository->addCommand($this->lastCommand, $this->answer, 'service');

        $this->sendMessage(trans('answers.input.frequency', [], $this->language), KeyboardHelper::actionKeyboard($this->language));

        $this->setCommand();
    }
}
