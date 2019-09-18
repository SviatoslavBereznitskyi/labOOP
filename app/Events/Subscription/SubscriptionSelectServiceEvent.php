<?php

namespace App\Events;

use App\Models\Message;
use App\Models\Subscription;
use App\Services\Contracts\SubscriptionServiceInterface;
use App\Services\Telegram\Commands;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Telegram;

class SubscriptionSelectServiceEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        if(false === isset(Subscription::getAvailableServices()[(int)$this->answer-1])){
            Telegram::sendMessage([
                'chat_id' => $this->telegramUserId,
                'text'=> Subscription::getMessageAvailableServices(),
                ]);

            return;
        }

        $subscriptionData = [
            'telegram_user_id' => $this->telegramUserId,
            'service' => Subscription::getAvailableServices()[$this->answer-1],
        ];

        $this->subscriptionService->updateOrCreate($subscriptionData);


        $subscription = $this->subscriptionService
            ->getByUserAndService($this->telegramUserId, Subscription::getAvailableServices()[$this->answer-1]);

        $this->commandService->setCommandMessage(get_class($this), $this->lastMessage->getKey(), $subscription);
    }
}
