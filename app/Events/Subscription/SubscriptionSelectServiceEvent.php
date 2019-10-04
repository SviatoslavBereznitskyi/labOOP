<?php

namespace App\Events;

use App\Models\Subscription;

/**
 * Class SubscriptionSelectServiceEvent
 *
 * @package App\Events
 */
class SubscriptionSelectServiceEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $services = Subscription::getAvailableServices();

        if (false === $this->checkService($services)) {
            return;
        }

        $subscriptionData = [
            'telegram_user_id' => $this->telegramUserId,
            'service' => $this->answer,
        ];

        $this->subscriptionService->updateOrCreate($subscriptionData);

        $subscription = $this->subscriptionService
            ->getByUserAndService($this->telegramUserId, $this->answer);

        $this->sendMessage(trans('answers.enter_key_words', [], $this->language));

        $this->setCommand($subscription);
    }
}
