<?php

namespace App\Events\Channel;

use App\Events\AnswerKeyboardCommandEvent;
use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use App\Repositories\Contracts\ChannelRepository;
use App\TelegramCommands\InlineCommands;

class ChannelDeleteEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $channelTitles = $this->telegramUser->channels()->pluck('title')->toArray();

        if(empty($channelTitles)){
            $this->sendMessage(trans('answers.input.no', [], $this->language));
            $this->lastCommand->delete();
            return;
        }
        if (false === $this->checkService($channelTitles)) {
            return;
        }


        $this->sendMessage(trans('answers.input.se', [], $this->language));


    }
}
