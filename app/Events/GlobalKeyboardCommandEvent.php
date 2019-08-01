<?php


namespace App\Events;


use App\Services\Contracts\SubscriptionServiceInterface;
use App\Services\Contracts\TelegramServiceInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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

    abstract function executeCommand();

    /**
     * GlobalKeyboardCommandEvent constructor.
     * @param $telegramUserId
     */
    public function __construct($telegramUserId)
    {
        $this->telegramUserId = $telegramUserId;
        $this->subscriptionService = resolve(SubscriptionServiceInterface::class);
        $this->telegramService = resolve(TelegramServiceInterface::class);
    }
}