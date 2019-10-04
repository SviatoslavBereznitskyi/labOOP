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
        'App\Events\SubscriptionEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\UnsubscriptionEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\UnsubscriptionSelectServiceEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\SubscriptionSelectServiceEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\SubscriptionKeywordsEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\ChangeFrequencyEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\SelectServiceEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\SetFrequencyEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\UnsubscriptionKeywordsEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\SubscriptionGetAllEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\Channel\ChannelEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\Channel\ChannelSelectEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\Channel\ChannelServiceSelectEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\Channel\ChannelActionSelectEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\Channel\ChannelAddEvent' => [
            'App\Handlers\GlobalEventHandler'
        ],
        'App\Events\Channel\ChannelDeleteEvent' => [
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
