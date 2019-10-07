<?php

namespace App\Events\Channel;


use App\Events\AnswerKeyboardCommandEvent;
use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Channel;
use App\Models\InlineCommand;
use App\Models\Subscription;
use App\TelegramCommands\InlineCommands;
use Exception;

class ChannelAddEvent extends AbstractChannelEvent
{
    public function executeCommand()
    {

        if ($this->answer === trans(InlineCommands::CANCEL, [], $this->language)) {
            $this->lastCommand->delete();
            $this->sendMessage(trans('answers.canceled', [], $this->language), KeyboardHelper::commandsKeyboard($this->language));

            return false;
        }

        $service = $this->lastCommand->getCommandsChain()['service'];
        try {
            $channel = $this->channelRepository->firstOrCreate([
                'username' => $this->answer,
                'service' => $service,
            ]);

            $this->channelRepository->attachUser($channel, $this->telegramUserId);
        } catch (Exception $exception) {
            $this->sendMessage($exception->getMessage());
            return;
        }


        $this->sendMessage(trans('answers.added', [], $this->language));


    }
}
