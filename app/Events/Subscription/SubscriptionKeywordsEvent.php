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
        $subscription = $this->getModel();

        array_walk($keywords, function (&$keyword){
            $keyword = trim($keyword);
        });

        $keywords = array_merge($subscription->getKeywords(), $keywords);

        $subscriptionData = [
            'keywords' => $keywords,
        ];

        $this->subscriptionService->update($subscriptionData, $subscription->getKey());

        $this->lastCommand->delete();

        $this->sendMessage(trans('answers.saved_keywords', [], $this->language), KeyboardHelper::commandsKeyboard($this->language   ));
    }
}
