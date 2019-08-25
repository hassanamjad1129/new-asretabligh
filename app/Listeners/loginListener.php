<?php

namespace App\Listeners;

use App\Events\loginEvent;
use App\Services\SMSService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class loginListener
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
     * @param loginEvent $event
     * @return void
     */
    public function handle(loginEvent $event)
    {
        $smsService = new SMSService([$event->user->phone]);
        $smsService->sendPatternSMS(398, ['password' => "\"چاپ عصر تبلیغ\"\nمشترک گرامی شما هم اکنون وارد سامانه شده اید."]);
    }
}
