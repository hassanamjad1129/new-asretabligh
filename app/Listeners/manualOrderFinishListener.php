<?php

namespace App\Listeners;

use App\Events\manualOrderFinishEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class manualOrderFinishListener
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
     * @param  manualOrderFinishEvent  $event
     * @return void
     */
    public function handle(manualOrderFinishEvent $event)
    {
        //
    }
}
