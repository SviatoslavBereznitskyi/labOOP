<?php

namespace App\Events\Channel;


use App\Events\AnswerKeyboardCommandEvent;
use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use App\Repositories\Contracts\ChannelRepository;
use App\TelegramCommands\InlineCommands;

class ChannelActionSelectEvent extends AbstractChannelEvent
{
    public function executeCommand()
    {
        $services = InlineCommands::getChannelsActionsTranslated($this->language);


        if (false === $this->checkService($services)) {
            return;
        }

        $usersChannels = $this->telegramUser->channels()->pluck('title')->toArray();
        $channels = array_values($this->channelRepository->pluck('title')->toArray());
        $notSubscribedChannels = array_diff($channels, $usersChannels);

        switch ($this->answer) {
            case trans('commands.action.' . InlineCommands::ADD_ACTION, [], $this->language):
                $items = [];
                $text = trans('answers.input.channels', [], $this->language);
                break;
            case trans('commands.action.' . InlineCommands::UNSUBSCRIBE_ACTION, [], $this->language):
                $items = $usersChannels;
                $text = trans('answers.selectOption', [], $this->language);
                break;
            case trans('commands.action.' . InlineCommands::SUBSCRIBE_ACTION, [], $this->language):
                $items = $notSubscribedChannels;
                $text = trans('answers.selectOption', [], $this->language);
                break;
            default:
                $items = [];
                $text = ' ';
        }

        $this->sendMessage($text, KeyboardHelper::channelsKeyboard($items, $this->language, $this->answer));

        $this->setCommand();
    }
}
