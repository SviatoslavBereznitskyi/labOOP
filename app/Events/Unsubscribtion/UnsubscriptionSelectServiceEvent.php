<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;

/**
 * Class UnsubscriptionSelectServiceEvent
 *
 * @package App\Events
 */
class UnsubscriptionSelectServiceEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $services = Subscription::getAvailableServices();

        if (false === $this->checkService($services)) {
            return;
        }

        $subscription = $this->subscriptionService
            ->getByUserAndService($this->telegramUserId, $this->answer);

        if (!$subscription) {

            $this->sendMessage(
                trans('answers.noSubscription', ['service' => $this->answer], $this->language),
                KeyboardHelper::commandsKeyboard($this->language)
            );

            $this->lastCommand->delete();

            return;
        }

        $items = $this->subscriptionService->getKeywordsForKeyboard($subscription->getKey());

        $this->sendMessage(
            trans('answers.choose_words_in_menu_for_delete', [], $this->language),
            KeyboardHelper::itemKeyboard($items, $this->language)
        );

        $this->setCommand($subscription);
    }
}
