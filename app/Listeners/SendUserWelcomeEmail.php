<?php

namespace App\Listeners;


use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\Mail;

class SendUserWelcomeEmail
{
    /**
     * Handle the event.
     *
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;

        Mail::send(new UserRegisteredMail($user));

    }
}
