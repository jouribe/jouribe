<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'title' => "string",
        'content' => "string",
        'summary' => "string",
        'category_id' => "int",
        'user_id' => "int",
        'published_at' => DateTime::class,
        'featured' => "bool",
        'draft' => "bool",
        'created_at' => DateTime::class,
        'updated_at' => DateTime::class,
    ])]
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraphs(5 , true),
            'summary' => $this->faker->sentence,
            'category_id' => $this->faker->numberBetween(1, 5),
            'user_id' => $this->faker->numberBetween(1, 11),
            'published_at' => $this->faker->dateTimeBetween('-5 years', '+2 months'),
            'featured' => $this->faker->boolean,
            'draft' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeBetween('-5 years', '+2 months'),
            'updated_at' => $this->faker->dateTimeBetween('-5 years', '+2 months'),
        ];
    }
}
