<?php

namespace App\Http\Controllers\Api;

use App\Events\NewUserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserController extends Controller
{
    /**
     * Get all resources.
     *
     * @return UserCollection
     */
    public function index(): UserCollection
    {
        return new UserCollection(User::with('posts')->simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(StoreUserRequest $request, UserService $userService): JsonResponse
    {
        $user = $userService->create($request);
        $userService->uploadAvatar($request, $user);

        NewUserRegistered::dispatch($user);

        return response()->json([
            'message' => 'User has been created',
            'user' => $user,
        ], 201);
    }

    /**
     * Show the specified resource.
     *
     * @param  User  $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @param  UserService  $userService
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, UserService $userService): JsonResponse
    {
        $userService->update($request);

        return response()->json([
            'message' => 'User has been updated',
        ]);
    }
}
