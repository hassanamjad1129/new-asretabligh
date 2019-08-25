<?php

namespace App\Jobs;

use App\Services\SMSService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SoapClient;
use SoapFault;

class sendWelcomeSMSJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $phone;

    /**
     * Create a new job instance.
     *
     * @param string $phone
     */
    public function __construct(string $phone)
    {
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $toNum = [$this->phone];

        $smsService = new SMSService($toNum);
        $smsService->sendPatternSMS(398, ['password' => "\"چاپ عصر تبلیغ\"\nمشترک گرامی شما هم اکنون وارد سامانه شده اید."]);
    }
}
