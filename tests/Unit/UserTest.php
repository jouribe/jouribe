<?php /** @noinspection StaticClosureCanBeUsedInspection */

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(fn () => User::factory()->create());

it('fetch a user', function () {
    $this->assertDatabaseHas('users', [
        'email' => $attributes['email'],
    ]);
});
