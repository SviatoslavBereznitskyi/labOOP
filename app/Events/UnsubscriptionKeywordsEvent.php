<?php

namespace App\Events;

use App\Models\Subscription;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Telegram;

class UnsubscriptionKeywordsEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $words = explode(' ', $this->answer);

        /** @var Subscription $model */
        $subscription = resolve($this->lastMessage->getModel())::query()->find($this->lastMessage->getModelId());

        $keywords = $subscription->getKeywords();

        foreach ($words as $word)
        {
            if (isset($keywords[$word])) {
                unset($keywords[$word]);
            }
        }

        $subscriptionData = [
            'keywords' => array_values($keywords),
        ];

        $this->subscriptionService->update($subscriptionData, $subscription->getKey());

        $this->lastMessage->delete();

        Telegram::sendMessage([
            'chat_id' => $this->telegramUserId,
            'text'=> trans('answers.deleted_keywords')]);
    }
}
