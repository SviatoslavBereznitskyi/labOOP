<?php

namespace App\Events\Channel;

use App\Events\AnswerKeyboardCommandEvent;
use App\Helpers\Telegram\KeyboardHelper;
use App\Models\Subscription;
use App\Repositories\Contracts\ChannelRepository;
use App\TelegramCommands\InlineCommands;
use Exception;

class ChannelDeleteEvent extends AbstractChannelEvent
{
    public function executeCommand()
    {
        $services = $this->channelRepository->pluck('title')->toArray();

        $usersChannels = $this->telegramUser->channels()->pluck('title')->toArray();

        $service = $this->lastCommand->getCommandsChain()['service'];

        if ($this->answer == trans(InlineCommands::DELETE_ALL, [], $this->language)) {
            $channel = $this->channelRepository->findWhereInTitle($usersChannels, $service);
            $this->telegramUser->channels()->detach($channel->pluck('id')->toArray());
            $usersChannels = [];
        } elseif (false === $this->checkService($services)) {
            return;
        } else{
            try {
                $channel = $this->channelRepository->findByTitle($this->answer, $service);
                if (($key = array_search($this->answer, $usersChannels)) !== false) {
                    unset($usersChannels[$key]);
                }
                $this->channelRepository->detachUser($channel, $this->telegramUserId);
            } catch (Exception $exception) {
                $this->sendMessage($exception->getMessage());
                return;
            }
        }

        $this->sendMessage(
            trans('answers.selectOption', [], $this->language),
            KeyboardHelper::channelsKeyboard($usersChannels, $this->language, trans('commands.action.' . InlineCommands::UNSUBSCRIBE_ACTION, [], $this->language))
        );

    }
}
