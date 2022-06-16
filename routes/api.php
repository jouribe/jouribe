<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users', static function (Request $request) {
    $user = User::create($request->all());

    if ($user) {
        return response()->json([
            'message' => 'User has been created',
        ], 201);
    }

    return response()->json([
        'message' => 'User has not been created'
    ], 422);
});
