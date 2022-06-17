<?php

namespace App\Http\Controllers\Api;

use App\Events\NewUserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(StoreUserRequest $request, UserService $service): JsonResponse
    {
        // User::with('latestPost')->get()->sortByDesc('latestPost.created_at');

        $user = $service->create($request);
        $service->uploadAvatar($request, $user);

        NewUserRegistered::dispatch($user);

        return response()->json([
            'message' => 'User has been created',
        ], 201);
    }
}
