<?php

use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    return view('welcome');
});

Route::post('/photo', static function (\Illuminate\Http\Request $request) {
    $path = $request->file('avatar')?->store('avatars', 'public');

    $request->user()->update([
        'avatar' => $path,
    ]);
});
