<?php

namespace App\Listeners;

use App\Events\registerEvent;
use App\Services\SMSService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class registerListener
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
     * @param registerEvent $event
     * @return void
     */
    public function handle(registerEvent $event)
    {
        $smsService = new SMSService([$event->user->phone]);
        $smsService->sendPatternSMS(398, ['password' => "\"چاپ عصر تبلیغ\"\nمشترک گرامی " . ($event->user->gender == 1 ? "خانم " : "آقای ") . $event->user->name . " \nبا تشکر از حسن انتخاب شما مدیریت عصر تبلیغ ورود شما را به این مجموعه خوش آمد می‏گوید."]);
    }

}
