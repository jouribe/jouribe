<?php

/** @noinspection StaticClosureCanBeUsedInspection */

use function Pest\Laravel\{get, getJson};

get('/')->assertStatus(200);

//getJson('api/users')->assertStatus(200);
