<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use Telegram\Bot\Laravel\Facades\Telegram;

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
        $language = Telegram::getWebhookUpdates()['message']['from']['language_code'];

        if(false === in_array($this->answer, $services)){

            $this->sendMessage(Subscription::getMessageAvailableServices());
            return;
        }

        $subscriptionData = [
            'telegram_user_id' => $this->telegramUserId,
            'service' => $this->answer,
        ];

        $this->subscriptionService->updateOrCreate($subscriptionData);


        $subscription = $this->subscriptionService
            ->getByUserAndService($this->telegramUserId, $this->answer);

        $this->sendMessage(trans('answers.enter_key_words', [], $language));

        $this->commandService->setCommandMessage(get_class($this), $this->lastMessage->getKey(), $subscription);
    }
}
