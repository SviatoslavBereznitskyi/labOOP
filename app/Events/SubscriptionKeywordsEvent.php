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
        Telegram::sendMessage([
            'chat_id' => $this->telegramUserId,
            'text'=> trans('answers.success1')]);

        $keywords = explode(' ', $this->answer);

        /** @var TelegramUser $telegramUser */
        $telegramUser = $this->telegramService->findOrCreateUser(['id' => $this->telegramUserId]);

        /** @var Subscription $subscription */
        $subscription = $telegramUser->subscriptions()->latest('updated_at')->first();

        $keywords = array_merge($subscription->getKeywords(), $keywords);

        $subscriptionData = [
            'keywords' => ($keywords),
        ];

        $this->subscriptionService->update($subscriptionData, $subscription->getKey());

        $this->lastMessage->setKeyboardCommand()->save();
    }
}
