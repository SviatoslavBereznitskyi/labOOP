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

class SetFrequencyEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $user = $this->telegramService->findOrCreateUser(['id' => $this->telegramUserId]);

        /** @var Subscription $model */
        $model = resolve($this->lastMessage->getModel())::query()->find($this->lastMessage->getModelId());

        if (false === is_numeric($this->answer)) {
            $this->rejectWithServices();

            return;
        }

        $model->frequency = $this->answer;
        $model->save();

        Telegram::sendMessage([
            'chat_id' => $this->telegramUserId,
            'text' => $model->frequency,
        ]);

        $this->lastMessage->delete();
    }
}
