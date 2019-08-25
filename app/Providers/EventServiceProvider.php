<?php

namespace App\Providers;

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
        'App\Events\loginEvent' => [
            'App\Listeners\loginListener',
        ],
        'App\Events\orderEvent' => [
            'App\Listeners\orderListener'
        ],
        'App\Events\finishOrderEvent' => [
            'App\Listeners\finishOrderListener'
        ],
        'App\Events\registerEvent' => [
            'App\Listeners\registerListener'
        ],
        'App\Events\manualRegisterEvent' => [
            'App\Listeners\manualRegisterListener'
        ],
        'App\Events\manualOrderFinishEvent' => [
            'App\Listeners\manualOrderFinishListener'
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
