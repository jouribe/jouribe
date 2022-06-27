<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use App\Notifications\NewUserAdminNotification;
use Illuminate\Support\Facades\Notification;

class NewUserNotifyAdminsListener
{
    /**
     * Handle the event.
     *
     * @param  NewUserRegistered  $event
     * @return void
     */
    public function handle(NewUserRegistered $event): void
    {
        Notification::route('mail', 'jorge@jouribe.dev')
            ->notify(new NewUserAdminNotification($event->user));
    }
}
