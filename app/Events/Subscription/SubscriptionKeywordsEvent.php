<?php

namespace App\Events;

use App\Models\Subscription;
use App\Models\TelegramUser;
use App\Services\TelegramService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Telegram;

class SubscriptionKeywordsEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $keywords = explode(' ', $this->answer);

        /** @var Subscription $model */
        $subscription = resolve($this->lastMessage->getModel())::query()->find($this->lastMessage->getModelId());

        $keywords = array_merge($subscription->getKeywords(), $keywords);

        $subscriptionData = [
            'keywords' => $keywords,
        ];

        $this->subscriptionService->update($subscriptionData, $subscription->getKey());

        $this->lastMessage->delete();

        $this->sendMessage(trans('answers.saved_keywords'));
    }
}
