<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Class SubscriptionKeywordsEvent
 *
 * @package App\Events
 */
class SubscriptionKeywordsEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $keywords = explode(',', $this->answer);
        $language = Telegram::getWebhookUpdates()['message']['from']['language_code'];

        /** @var Subscription $model */
        $subscription = resolve($this->lastMessage->getModel())::query()->find($this->lastMessage->getModelId());

        $keywords = array_merge($subscription->getKeywords(), $keywords);

        $subscriptionData = [
            'keywords' => $keywords,
        ];

        $this->subscriptionService->update($subscriptionData, $subscription->getKey());

        $this->lastMessage->delete();

        $this->sendMessage(trans('answers.saved_keywords', [], $language), KeyboardHelper::commandsKeyboard($language));
    }
}
