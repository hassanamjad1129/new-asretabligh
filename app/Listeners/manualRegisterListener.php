<?php

namespace App\Listeners;

use App\Events\manualRegisterEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class manualRegisterListener
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
     * @param  manualRegisterEvent  $event
     * @return void
     */
    public function handle(manualRegisterEvent $event)
    {
        //
    }
}
