<?php

namespace App\Listeners;


use App\Mail\UserAccountConfirmationMail;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\Mail;

class SendUserAccountConfirmationEmail
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

        // IF REGISTERED WITH EMAIL
        if(!$user->facebook_id) {
            Mail::send(new UserAccountConfirmationMail($user));
        }

    }
}
