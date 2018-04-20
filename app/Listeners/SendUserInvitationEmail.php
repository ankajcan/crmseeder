<?php

namespace App\Listeners;


use App\Mail\UserInvitationMail;
use Illuminate\Support\Facades\Mail;

class SendUserInvitationEmail
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

        Mail::send(new UserInvitationMail($user));

    }
}
