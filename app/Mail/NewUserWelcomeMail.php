<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewUserWelcomeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * User instance.
     *
     * @var User
     */
    private User $user;

    /**
     * Create a new notification instance.
     *
     * @param  User  $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * New User Welcome Email.
     *
     * @return NewUserWelcomeMail
     */
    public function build(): NewUserWelcomeMail
    {
        return $this
            ->markdown('emails.new-user-welcome')
            ->with([
                'user' => $this->user,
            ]);
    }
}
