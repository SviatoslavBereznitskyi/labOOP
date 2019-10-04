<?php

namespace App\Events\Channel;


use App\Events\AnswerKeyboardCommandEvent;
use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use App\Repositories\Contracts\ChannelRepository;
use App\TelegramCommands\InlineCommands;

class ChannelActionSelectEvent extends AnswerKeyboardCommandEvent
{
    public function executeCommand()
    {
        $services = InlineCommands::getChannelsActionsTranslated($this->language);


        if (false === $this->checkService($services)) {
            return;
        }

        /** @var ChannelRepository $channelsRepository */
        $channelsRepository = resolve(ChannelRepository::class);

        switch ($this->answer) {
            case trans('commands.action.' . InlineCommands::ADD_ACTION, [], $this->language):
                $text = trans('answers.input.channels', [], $this->language);
                break;
            case trans('commands.action.' . InlineCommands::UNSUBSCRIBE_ACTION, [], $this->language):
                $items = $this->telegramUser->channels()->pluck('title')->toArray();
                $text = trans('answers.selectService', [], $this->language);
                break;
            case trans('commands.action.' . InlineCommands::SUBSCRIBE_ACTION, [], $this->language):
                $items = array_values($channelsRepository->pluck('title')->toArray());
                $text = trans('answers.selectService', [], $this->language);
                break;
            default:
                $text = ' ';
        }

        $this->sendMessage($text, KeyboardHelper::channelsKeyboard($items, $this->language, $this->answer));

        $this->setCommand();
    }
}
