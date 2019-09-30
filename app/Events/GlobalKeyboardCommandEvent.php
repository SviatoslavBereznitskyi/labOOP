<?php

namespace App\Events;

use App\Models\TelegramUser;
use App\Repositories\Contracts\CommandRepository;
use App\Services\Contracts\CommandServiceInterface;
use App\Services\Contracts\SubscriptionServiceInterface;
use App\Services\Contracts\TelegramServiceInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Telegram\Bot\Laravel\Facades\Telegram;

abstract class GlobalKeyboardCommandEvent
{

    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $telegramUserId;

    /**
     * @var SubscriptionServiceInterface
     */
    protected $subscriptionService;

    /**
     * @var TelegramServiceInterface
     */
    protected $telegramService;

    /**
     * @var CommandRepository
     */
    protected $messageRepository;

    /**
     * @var CommandServiceInterface
     */
    protected $commandService;

    /**
     * @var string
     */
    protected $language;

    abstract function executeCommand();

    /**
     * GlobalKeyboardCommandEvent constructor.
     * @param $telegramUser
     */
    public function __construct(TelegramUser $telegramUser)
    {
        $this->telegramUserId = $telegramUser->getKey();
        $this->subscriptionService = resolve(SubscriptionServiceInterface::class);
        $this->telegramService = resolve(TelegramServiceInterface::class);
        $this->messageRepository = resolve(CommandRepository::class);
        $this->commandService = resolve(CommandServiceInterface::class);
        $this->language = $telegramUser->getLocale();
    }

    /**
     * @param $message
     */
    public function sendMessage($message, $keyboard = null)
    {
        Telegram::sendMessage([
            'chat_id'      => $this->telegramUserId,
            'text'         => $message,
            'reply_markup' => $keyboard,
            'parse_mode'   => 'HTML',
        ]);
    }
}