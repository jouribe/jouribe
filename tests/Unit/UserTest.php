<?php /** @noinspection StaticClosureCanBeUsedInspection */

uses(Tests\TestCase::class);

it('fetch a user', function () {
    $this->assertDatabaseHas('users', [
        'email' => 'jorge@jouribe.dev',
    ]);
});
