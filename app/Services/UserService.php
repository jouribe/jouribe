<?php

namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
     * @param  StoreUserRequest  $request
     * @return User
     */
    public function create(StoreUserRequest $request): User
    {
        return User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
    }

    /**
     * Update a user.
     *
     * @param  UpdateUserRequest  $request
     * @return bool
     */
    public function update(UpdateUserRequest $request): bool
    {
        return User::update([
            'id' => $request->get('id'),
        ], [
            'name' => $request->get('name'),
            'email' => $request->get('email')
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
