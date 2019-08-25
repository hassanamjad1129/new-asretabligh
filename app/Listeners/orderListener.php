<?php

namespace App\Listeners;

use App\Events\orderEvent;
use App\Services\SMSService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class orderListener
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
     * @param orderEvent $event
     * @return void
     */
    public function handle(orderEvent $event)
    {
        $smsService = new SMSService([$event->user->phone]);
        $smsService->sendPatternSMS(398, ['password' => "\"چاپ عصر تبلیغ\"\nمشترک گرامی سفارش شما در سامانه عصر تبلیغ به شماره پیگیری : " . $event->trackingCode . " ثبت و در نوبت چاپ قرار گرفت."]);
    }
}
