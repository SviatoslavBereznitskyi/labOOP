<?php

namespace App\Handlers;

use App\Events\GlobalKeyboardCommandEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GlobalEventHandler
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UnsubscriptionEvent  $event
     * @return void
     */
    public function handle(GlobalKeyboardCommandEvent $event)
    {
        $event->executeCommand();
    }
}
