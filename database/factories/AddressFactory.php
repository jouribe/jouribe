<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @return array
     */
    #[ArrayShape([
        'type' => 'string',
        'street' => 'string',
        'city' => 'string',
        'state' => 'string',
        'zip' => 'string',
        'user_id' => 'mixed',
    ])]
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['home', 'work']),
            'street' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->word(),
            'zip' => $this->faker->postcode(),
            'user_id' => $this->faker->numberBetween(1, User::count()),
        ];
    }
}
