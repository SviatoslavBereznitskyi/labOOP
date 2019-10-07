<?php


namespace App\Events\Channel;


use App\Events\AnswerKeyboardCommandEvent;
use App\Models\InlineCommand;
use App\Models\TelegramUser;
use App\Repositories\Contracts\ChannelRepository;

abstract class AbstractChannelEvent extends AnswerKeyboardCommandEvent
{
    /**
     * @var ChannelRepository
     */
    protected $channelRepository;

    public function __construct(TelegramUser $telegramUser, $answer, InlineCommand $lastMessage)
    {
        parent::__construct($telegramUser, $answer, $lastMessage);
        $this->channelRepository = resolve(ChannelRepository::class);
    }
}