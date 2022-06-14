<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    $media = Post::find(1)?->getFirstMedia('post_banner');

    return view('welcome', compact('media'));
});
