<?php

/** @noinspection StaticClosureCanBeUsedInspection */

use function Pest\Laravel\get;

get('/')->assertStatus(200);
