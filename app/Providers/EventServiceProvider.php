<?php

namespace App\Providers;

use App\Events\UserInvited;
use App\Events\UserRegistered;
use App\Listeners\SendUserAccountConfirmationEmail;
use App\Listeners\SendUserInvitationEmail;
use App\Listeners\SendUserWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegistered::class => [
            SendUserWelcomeEmail::class,
            SendUserAccountConfirmationEmail::class
        ],
        UserInvited::class => [
            SendUserInvitationEmail::class
        ]
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
