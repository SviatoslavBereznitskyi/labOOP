<?php

namespace App\Providers;

use App\Events\SubscriptionEvent;
use App\Events\UnsubscriptionEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SubscriptionEvent::class => [
            'App\Handlers\GlobalEventHandler'
        ],
        UnsubscriptionEvent::class => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\UnsubscriptionAnswerEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\SubscriptionAnswerEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\SubscriptionKeywordsEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\ChangeFrequencyEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\ChangeFrequencyAnswerEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\SetFrequencyEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\UnsubscriptionKeywordsEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
