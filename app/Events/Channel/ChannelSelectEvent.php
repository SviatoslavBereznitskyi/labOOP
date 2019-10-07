<?php

namespace App\Events\Channel;


use App\Events\AnswerKeyboardCommandEvent;
use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use App\TelegramCommands\InlineCommands;
use Exception;

class ChannelSelectEvent extends AbstractChannelEvent
{
    public function executeCommand()
    {
        $services = $this->channelRepository->pluck('title')->toArray();

        $usersChannels = $this->telegramUser->channels()->pluck('title')->toArray();
        $channels = array_values($this->channelRepository->pluck('title')->toArray());
        $notSubscribedChannels = array_diff($channels, $usersChannels);

        $service = $this->lastCommand->getCommandsChain()['service'];

        if ($this->answer == trans(InlineCommands::SELECT_ALL, [], $this->language)) {
            $channel = $this->channelRepository->findWhereInTitle($notSubscribedChannels, $service);
            $this->telegramUser->channels()->attach($channel->pluck('id')->toArray());
            $notSubscribedChannels = [];
        } elseif (false === $this->checkService($services)) {
            return;
        } else{
            try {
                $channel = $this->channelRepository->findByTitle($this->answer, $service);
                if (($key = array_search($this->answer, $notSubscribedChannels)) !== false) {
                    unset($notSubscribedChannels[$key]);
                }
                $this->channelRepository->attachUser($channel, $this->telegramUserId);
            } catch (Exception $exception) {
                $this->sendMessage($exception->getMessage());
                return;
            }
        }

        $this->sendMessage(
            trans('answers.selectService', [], $this->language),
            KeyboardHelper::channelsKeyboard($notSubscribedChannels, $this->language, trans('commands.action.' . InlineCommands::SUBSCRIBE_ACTION, [], $this->language))
        );

    }
}
