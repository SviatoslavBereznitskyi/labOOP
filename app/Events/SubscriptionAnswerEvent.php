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

class SubscriptionAnswerEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        if(false === isset(Subscription::getAvailableServices()[$this->answer])){
            Telegram::sendMessage([
                'chat_id' => $this->telegramUserId,
                'text'=> trans('answers.try_again')]);

            return;
        }

        $subscriptionData = [
            'telegram_user_id' => $this->telegramUserId,
            'service' => Subscription::getAvailableServices()[$this->answer],
        ];

        $this->subscriptionService->updateOrCreate($subscriptionData);

        Telegram::sendMessage([
            'chat_id' => $this->telegramUserId,
            'text'=> trans('answers.success')]);

        $this->lastMessage->setKeyboardCommand(Commands::SUBSCRIBE_ANSWER_EVENT)->save();
    }
}
