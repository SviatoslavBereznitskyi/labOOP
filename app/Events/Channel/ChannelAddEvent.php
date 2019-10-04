<?php

namespace App\Events\Channel;


use App\Events\AnswerKeyboardCommandEvent;
use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use App\TelegramCommands\InlineCommands;

class ChannelAddEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {

        if ($this->answer === trans(InlineCommands::CANCEL, [], $this->language)) {
            $this->lastCommand->delete();
            $this->sendMessage(trans('answers.canceled', [], $this->language), KeyboardHelper::commandsKeyboard($this->language));

            return false;
        }


        $subscription = $this->subscriptionService
            ->getByUserAndService($this->telegramUserId, $this->answer);

        if(null === $subscription){
            $this->lastCommand->delete();
            $this->sendMessage(trans('answers.noSubscription', ['service' => $this->answer], $this->language), KeyboardHelper::commandsKeyboard($this->language));
            return;
        }

        $this->sendMessage(trans('answers.input.frequency', [], $this->language), KeyboardHelper::frequencyKeyboard($this->language));


    }
}
