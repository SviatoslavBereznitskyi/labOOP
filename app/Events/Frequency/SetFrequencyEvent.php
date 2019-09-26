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

        if (false === in_array($this->answer, Subscription::getAvailableFrequencies())) {
            $this->sendMessage(trans('answers.select_category', [], $this->language), KeyboardHelper::frequencyKeyboard($this->language));
            return false;
        }

        if (false === is_numeric($this->answer)) {
            $this->rejectWithServices();

            return;
        }
        $model->frequency = $this->answer;

        $model->save();

        $this->sendMessage(trans('answers.frequency_changed', [], $this->language), KeyboardHelper::commandsKeyboard($this->language));

        $this->lastCommand->delete();
    }
}
