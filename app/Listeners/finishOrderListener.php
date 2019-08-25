<?php

namespace App\Listeners;

use App\Events\finishOrderEvent;
use App\Services\SMSService;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class finishOrderListener
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
     * @param finishOrderEvent $event
     * @return void
     */
    public function handle(finishOrderEvent $event)
    {
        $smsService = new SMSService([$event->order->user->phone]);
        $smsService->sendPatternSMS(398, ['password' => "\"چاپ عصر تبلیغ\"\nمشترک گرامی سفارش شما به شماره پیگیری " . $event->order->id . ' آماده تحویل است.']);
    }
}
