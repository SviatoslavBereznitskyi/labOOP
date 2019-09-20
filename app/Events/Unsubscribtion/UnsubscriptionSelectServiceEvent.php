<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use Telegram\Bot\Laravel\Facades\Telegram;

/**
 * Class UnsubscriptionSelectServiceEvent
 *
 * @package App\Events
 */
class UnsubscriptionSelectServiceEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $language = Telegram::getWebhookUpdates()['message']['from']['language_code'];

        $services = Subscription::getAvailableServices();

        if (false === in_array($this->answer, $services)) {

            $this->sendMessage(Subscription::getMessageAvailableServices());

            return;
        }

        $subscription = $this->subscriptionService
            ->getByUserAndService($this->telegramUserId, $this->answer);

        if (!$subscription) {

            $this->sendMessage(trans('answers.no_words'));

            $this->lastMessage->delete();

            return;
        }

        $items = $this->subscriptionService->getKeywordsForKeyboard($subscription->getKey());

        $this->sendMessage(
            trans('answers.choose_words_in_menu_for_delete', [], $language),
            KeyboardHelper::itemKeyboard($items, $language)
        );

        $this->commandService->setCommandMessage(get_class($this), $this->lastMessage->getKey(), $subscription);
    }
}
