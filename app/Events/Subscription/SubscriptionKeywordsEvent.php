<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;

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

        /** @var Subscription $model */
        $subscription = resolve($this->lastCommand->getModel())::query()->find($this->lastCommand->getModelId());

        $keywords = array_merge($subscription->getKeywords(), $keywords);

        $subscriptionData = [
            'keywords' => $keywords,
        ];

        $this->subscriptionService->update($subscriptionData, $subscription->getKey());

        $this->lastCommand->delete();

        $this->sendMessage(trans('answers.saved_keywords', [], $this->language), KeyboardHelper::commandsKeyboard($this->language   ));
    }
}
