<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserService
{
    /**
     * Create a new user.
     *
     * @param  Request  $request
     * @return User
     */
    public function create(Request $request): User
    {
        return User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
    }

    /**
     * Upload a profile picture for a user.
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function uploadAvatar(Request $request, User $user): void
    {
        if ($request->hasFile('avatar') && $request->file('avatar')?->isValid()) {
            $user->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }
    }

    /**
     * Send welcome notification to a new user.
     *
     * @param  User  $user
     * @return void
     */
    public function sendWelcomeEmail(User $user): void
    {
        $user->notify(new NewUserNotification($user));
    }
}
