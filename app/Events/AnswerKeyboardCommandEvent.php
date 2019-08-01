<?php


namespace App\Events;


use App\Models\Message;
use App\Models\Subscription;
use Telegram;

abstract class AnswerKeyboardCommandEvent extends GlobalKeyboardCommandEvent
{
    protected $answer;
    /**
     * @var Message
     */
    protected $lastMessage;

    public function __construct($telegramUserId, $answer, Message $lastMessage)
    {
        parent::__construct($telegramUserId);
        $this->answer = $answer;
        $this->lastMessage = $lastMessage;
    }

    protected function rejectWithServices()
    {
        Telegram::sendMessage([
            'chat_id' => $this->telegramUserId,
            'text'=> Subscription::getMessageAvailableServices(),
        ]);
    }
}