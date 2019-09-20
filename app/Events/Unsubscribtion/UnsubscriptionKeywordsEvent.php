<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
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

/**
 * Class UnsubscriptionKeywordsEvent
 *
 * @package App\Events
 */
class UnsubscriptionKeywordsEvent extends AnswerKeyboardCommandEvent
{

    /**
     * @throws \Exception
     */
    public function executeCommand()
    {
        $language = Telegram::getWebhookUpdates()['message']['from']['language_code'];
        $subscription = resolve($this->lastMessage->getModel())::query()->find($this->lastMessage->getModelId());

        if ($this->answer !== trans(Commands::DONE, [], $language)) {

            $answer = 'answers.deleted_keyword';

            $keywords = $subscription->getKeywords();

            if (in_array($this->answer, $keywords)) {
                $key = array_search($this->answer, $keywords);
                unset($keywords[$key]);
            }

            $subscriptionData = [
                'keywords' => array_values($keywords),
            ];

            $this->subscriptionService->update($subscriptionData, $subscription->getKey());

            $items = $this->subscriptionService->getKeywordsForKeyboard($subscription->getKey());

            if ($this->answer === trans(Commands::DELETE_ALL, [], $language)) {
                $this->subscriptionService->update(['keywords' => []], $subscription->getKey());

                $items = [];
                $answer = 'answers.deleted_keywords';
            }

            $this->sendMessage(trans($answer, [], $language), KeyboardHelper::itemKeyboard($items, $language));

            return;
        }

        $this->sendMessage(trans(Commands::DONE, [], $language), KeyboardHelper::commandsKeyboard());
        $this->lastMessage->delete();
    }
}
