<?php

namespace App\Listeners;

use App\Events\NewUserRegistered;
use App\Services\UserService;

class NewUserWelcomeEmailListener
{
    /**
     * Handle the event.
     *
     * @param  NewUserRegistered  $event
     * @param  UserService  $userService
     * @return void
     */
    public function handle(NewUserRegistered $event): void
    {
        (new UserService)->sendWelcomeEmail($event->user);
    }
}
