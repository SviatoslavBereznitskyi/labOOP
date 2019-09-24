<?php


namespace App\Events;


use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Command;
use App\Services\Telegram\Commands;

abstract class AnswerKeyboardCommandEvent extends GlobalKeyboardCommandEvent
{
    protected $answer;
    /**
     * @var Command
     */
    protected $lastCommand;

    public function __construct($telegramUserId, $answer, Command $lastMessage)
    {
        parent::__construct($telegramUserId);
        $this->answer = $answer;
        $this->lastCommand = $lastMessage;
    }


    protected function rejectWithServices()
    {
        $this->sendMessage(trans('answers.select_category', [], $this->language), KeyboardHelper::networkKeyboard($this->language));
    }

    /**
     * @param array $services
     * @return bool
     * @throws \Exception
     */
    protected function checkService(array $services)
    {
        if ($this->answer === trans(Commands::CANCEL, [], $this->language)) {
            $this->lastCommand->delete();
            $this->sendMessage(trans('answers.canceled', [], $this->language), KeyboardHelper::commandsKeyboard());

            return false;
        }

        if (false === in_array($this->answer, $services)) {
            $this->rejectWithServices();

            return false;
        }

        return true;
    }
}