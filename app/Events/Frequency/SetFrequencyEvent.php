<?php

namespace App\Events;

use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use App\TelegramCommands\InlineCommands;

class SetFrequencyEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        /** @var Subscription $model */
        $model = resolve($this->lastCommand->getModel())::query()->find($this->lastCommand->getModelId());

        if ($this->answer === trans(InlineCommands::CANCEL, [], $this->language)) {
            $this->lastCommand->delete();
            $this->sendMessage(trans('answers.canceled', [], $this->language), KeyboardHelper::commandsKeyboard($this->language));

            return false;
        }

        $frequency = array_search($this->answer, Subscription::getAvailableFrequenciesForHuman($this->language));

        if (false === $frequency) {
            $this->sendMessage(trans('answers.selectFrequency', [], $this->language), KeyboardHelper::frequencyKeyboard($this->language));
            return false;
        }

        $model->frequency = $frequency;

        $model->save();

        $this->sendMessage(trans('answers.frequency_changed', [], $this->language), KeyboardHelper::commandsKeyboard($this->language));

        $this->lastCommand->delete();
    }
}
