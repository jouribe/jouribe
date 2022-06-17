<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use App\Notifications\NewUserNotification;

class NewUserWelcomeEmailListener
{
    /**
     * Handle the event.
     *
     * @param  NewUserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event): void
    {
        $event->user->notify(new NewUserNotification($event->user));
    }
}
