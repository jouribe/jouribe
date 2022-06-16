<?php /** @noinspection StaticClosureCanBeUsedInspection */

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

beforeEach(fn () => User::factory()->create());

it('can create a user', function() {
    $attributes = User::factory()->raw();
    $response = $this->postJson('api/users', $attributes);
    $response->assertStatus(201)->assertJson(['message' => 'User has been created']);
    $this->assertDatabaseHas('users', [
        'email' => $attributes['email'],
    ]);
});
