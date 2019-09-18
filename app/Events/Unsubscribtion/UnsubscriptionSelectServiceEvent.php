<?php

namespace App\Events;

use App\Models\Subscription;
use App\Services\Telegram\Commands;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Telegram;

class UnsubscriptionSelectServiceEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        if (false === isset(Subscription::getAvailableServices()[(int)$this->answer - 1])) {

            $this->sendMessage(Subscription::getMessageAvailableServices());

            return;
        }

        $subscription = $this->subscriptionService
            ->getByUserAndService($this->telegramUserId, Subscription::getAvailableServices()[$this->answer - 1]);

        if (!$subscription) {

            $this->sendMessage(trans('answers.no_words'));

            $this->lastMessage->delete();

            return;
        }

        $text = $this->subscriptionService->getKeywords($subscription->getKey());

        $this->sendMessage($text);

        $this->commandService->setCommandMessage(get_class($this), $this->lastMessage->getKey(), $subscription);
    }
}
