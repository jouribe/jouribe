<?php /** @noinspection StaticClosureCanBeUsedInspection */

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(fn () => User::factory()->create());

it('can create a user', function() {
    $attributes = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    $response = $this->postJson('api/users', $attributes);
    $response->assertStatus(201)->assertJson(['message' => 'User has been created']);

    $this->assertDatabaseHas('users', [
        'email' => $attributes['email'],
    ]);
});
