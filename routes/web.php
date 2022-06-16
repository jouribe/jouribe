<?php

use Illuminate\Support\Facades\Route;

Route::get('/', static function () {
    //$media = Post::find(1)?->getFirstMedia('post_banner');
    return view('welcome');
});
