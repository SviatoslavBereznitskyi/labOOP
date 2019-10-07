<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
use App\TelegramCommands\InlineCommands;

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

        $subscription = $this->getModel();

        switch ($this->answer) {
            case trans(InlineCommands::DONE, [], $this->language):
                $this->doneCommand($this->language);
                return;
            case $this->answer === trans(InlineCommands::DELETE_ALL, [], $this->language):
                $this->deleteAllCommand($subscription->getKey(), $this->language);
                return;
        }

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

        $this->sendMessage(trans('answers.deleted_keyword', [], $this->language), KeyboardHelper::itemKeyboard($items, $this->language));

        return;


    }

    private function doneCommand($language)
    {
        $this->sendMessage(trans(InlineCommands::DONE, [], $language), KeyboardHelper::commandsKeyboard($this->language));
        $this->lastCommand->delete();
    }

    private function deleteAllCommand($subscriptionId, $language)
    {
        $this->subscriptionService->delete($subscriptionId);

        $this->sendMessage(trans('answers.deleted_keywords', [], $language), KeyboardHelper::commandsKeyboard($this->language));

        $this->lastCommand->delete();
    }
}
