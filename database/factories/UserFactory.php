<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'name' => 'string',
        'email' => 'string',
        'email_verified_at' => Carbon::class,
        'password' => 'string',
        'remember_token' => 'string',
        'created_at' => Carbon::class,
        'updated_at' => Carbon::class,
    ])]
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => $this->faker->dateTimeBetween('-5 years'),
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
            'created_at' => $this->faker->dateTimeBetween('-5 years'),
            'updated_at' => $this->faker->dateTimeBetween('-5 years'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     * @noinspection PhpUnusedParameterInspection
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
