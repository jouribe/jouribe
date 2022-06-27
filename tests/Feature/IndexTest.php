<?php

/** @noinspection StaticClosureCanBeUsedInspection */

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

get('/')->assertStatus(200);

//getJson('api/users')->assertStatus(200);
